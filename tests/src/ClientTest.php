<?php
namespace Nataniel\BoardGameGeekTest;

use PHPUnit\Framework\TestCase;
use Nataniel\BoardGameGeek;

class ClientTest extends TestCase
{
    /**
     * https://boardgamegeek.com/boardgame/39856/dixit
     * @covers BoardGameGeek\Client::getThing
     */
    public function testGetThing()
    {
        $client = new BoardGameGeek\Client();
        $thing = $client->getThing(5371611111, true);
        $this->assertNull($thing);

        $thing = $client->getThing(39856, true);
        $this->assertInstanceOf(BoardGameGeek\Boardgame::class, $thing);
        $this->assertEquals('Dixit', $thing->getName());
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/thing?id=209671,194880
     * @covers BoardGameGeek\Client::getThing
     */
    public function testGetThings()
    {
        $client = new BoardGameGeek\Client();
        $things = $client->getThings([ 209671, 194880 ], true);

        $this->assertCount(2, $things);
        foreach ($things as $thing) {
            $this->assertInstanceOf(BoardGameGeek\Thing::class, $thing);
            $this->assertContains($thing->getName(), [ 'Zona: The Secret of Chernobyl', 'Dream Home' ]);
        }
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/hot?type=boardgame
     * @covers BoardGameGeek\Client::getHotItems
     */
    public function testGetHotItems()
    {
        $client = new BoardGameGeek\Client();
        $items = $client->getHotItems();

        # empty hot list? error on BGG?
        # $this->assertNotEmpty($items);
        foreach ($items as $i => $item) {
            $this->assertInstanceOf(BoardGameGeek\HotItem::class, $item);
            $this->assertEquals($i + 1, $item->getRank());
            $this->assertNotEmpty($item->getName());
        }
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/search/?query=Domek&type=boardgame
     * @covers BoardGameGeek\Client::search
     */
    public function testSearch()
    {
        $client = new BoardGameGeek\Client();
        $search = $client->search('Domek', false, BoardGameGeek\Type::BOARDGAME);

        $this->assertInstanceOf(BoardGameGeek\Search\Query::class, $search);
        $this->assertGreaterThan(1, count($search));
        foreach ($search as $result) {
            $this->assertInstanceOf(BoardGameGeek\Search\Result::class, $result);
            $this->assertNotEmpty($result->getName());
        }
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/collection?username=nataniel
     * @covers BoardGameGeek\Client::getCollection
     */
    public function testGetCollection()
    {
        $client = new BoardGameGeek\Client();
        $this->expectException(BoardGameGeek\Exception::class);
        $client->getCollection([ 'username' => 'notexistingusername' ]);

        $items = $client->getCollection([ 'username' => 'nataniel' ]);
        $this->assertInstanceOf(BoardGameGeek\Collection::class, $items);
        $this->assertNotEmpty($items);
        foreach ($items as $i => $item) {
            $this->assertInstanceOf(BoardGameGeek\Collection\Item::class, $item);
            $this->assertNotEmpty($item->getName());
            $this->assertStringStartsWith('https://cf.geekdo-images.com', $item->getImage());
        }
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/plays?username=nataniel
     * @covers BoardGameGeek\Client::getPlays
     */
    public function testGetPlays()
    {
        $client = new BoardGameGeek\Client();
        $plays = $client->getPlays([
            'username' => 'nataniel',
            'mindate' => '2005-02-07',
            'maxdate' => '2005-02-07',
        ]);

        $this->assertNotEmpty($plays);

        foreach ($plays as $play) {
            $this->assertInstanceOf(BoardGameGeek\Play::class, $play);
            $this->assertEquals('2005-02-07', $play->getDate());
            $this->assertEquals(1, $play->getQuantity());
            $this->assertEquals('thing', $play->getObjectType());
            $this->assertEquals(3307, $play->getObjectId());
            $this->assertEquals('Wallenstein', $play->getObjectName());
        }
    }

    /**
     * https://www.boardgamegeek.com/xmlapi2/user?name=nataniel
     * @covers BoardGameGeek\Client::getUser
     */
    public function testGetUser()
    {
        $client = new BoardGameGeek\Client();
        $item = $client->getUser('notexistingusername');
        $this->assertNull($item);

        $item = $client->getUser('nataniel');
        $this->assertInstanceOf(BoardGameGeek\User::class, $item);
        $this->assertEquals('Artur', $item->getFirstName());
        $this->assertEquals('2004', $item->getYearRegistered());
        $this->assertStringStartsWith('https://cf.geekdo-static.com', $item->getAvatar());
    }
}
