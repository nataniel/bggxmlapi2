<?php
namespace Nataniel\BoardGameGeekTest;

use PHPUnit\Framework\TestCase;
use Nataniel\BoardGameGeek;

class ClientTest extends TestCase
{
    /**
     * @covers BoardGameGeek\Client::getThing
     */
    public function testGetThing()
    {
        $client = new BoardGameGeek\Client();

        // https://boardgamegeek.com/boardgame/39856/dixit
        $thing = $client->getThing(39856, true);
        $this->assertInstanceOf(BoardGameGeek\Thing::class, $thing);
        $this->assertEquals('Dixit', $thing->getName());
    }

    /**
     * @covers BoardGameGeek\Client::searchThing
     */
    public function testSearchThing()
    {
        $client = new BoardGameGeek\Client();

        // https://www.boardgamegeek.com/xmlapi2/search/?query=Domek&type=boardgame
        $search = $client->search('Domek', false, BoardGameGeek\Client::TYPE_BOARDGAME);

        $this->assertInstanceOf(BoardGameGeek\Search\Query::class, $search);
        $this->assertGreaterThan(1, count($search));
        $this->assertInstanceOf(BoardGameGeek\Search\Result::class, $search[0]);
    }
}