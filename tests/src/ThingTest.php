<?php
namespace Nataniel\BoardGameGeekTest;

use PHPUnit\Framework\TestCase;
use Nataniel\BoardGameGeek;

class ThingTest extends TestCase
{
    /** @var BoardGameGeek\Thing */
    private $thing;

    public function setUp()
    {
        $xml = simplexml_load_file(__DIR__ . '/../files/thing.xml');
        $this->thing = new BoardGameGeek\Thing($xml->item);
    }

    public function testGetName()
    {
        $this->assertEquals('Dream Home', $this->thing->getName());
    }

    public function testGetLinks()
    {
        $this->assertCount(16, $this->thing->getLinks());
        foreach ($this->thing->getLinks() as $item) {
            $this->assertInstanceOf(BoardGameGeek\Boardgame\Link::class, $item);
        }
    }

    public function testGetDesigners()
    {
        $items = $this->thing->getBoardgameDesigners();
        $this->assertCount(1, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Designer::class, $item);
        $this->assertEquals('Klemens Kalicki', $item->getName());
        $this->assertEquals(89488, $item->getId());
    }

    public function testGetCategories()
    {
        $items = $this->thing->getBoardgameCategories();
        $this->assertCount(1, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Category::class, $item);
        $this->assertEquals('Card Game', $item->getName());
        $this->assertEquals(1002, $item->getId());
    }

    public function testGetMechanics()
    {
        $items = $this->thing->getBoardgameMechanics();
        $this->assertCount(4, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Mechanic::class, $item);
        $this->assertEquals('Card Drafting', $item->getName());
        $this->assertEquals(2041, $item->getId());
    }

    public function testGetExpansions()
    {
        $items = $this->thing->getBoardgameExpansions();
        $this->assertCount(2, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Expansion::class, $item);
        $this->assertEquals('Domek: Promo Token – Car', $item->getName());
        $this->assertEquals(208871, $item->getId());
    }

    public function testGetArtists()
    {
        $items = $this->thing->getBoardgameArtists();
        $this->assertCount(1, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Artist::class, $item);
        $this->assertEquals('Bartłomiej Kordowski', $item->getName());
        $this->assertEquals(53716, $item->getId());
    }

    public function testGetPublishers()
    {
        $items = $this->thing->getBoardgamePublishers();
        $this->assertCount(7, $items);

        $item = $items[0];
        $this->assertInstanceOf(BoardGameGeek\Boardgame\Publisher::class, $item);
        $this->assertEquals('ADC Blackfire Entertainment', $item->getName());
        $this->assertEquals(23043, $item->getId());
    }
}