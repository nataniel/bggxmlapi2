<?php
namespace Nataniel\BoardGameGeekTest;

use PHPUnit\Framework\TestCase;
use Nataniel\BoardGameGeek;

class ThingTest extends TestCase
{
    public function testGetName()
    {
        $xml = simplexml_load_file(__DIR__ . '/../files/thing.xml');
        $thing = new BoardGameGeek\Thing($xml->item);

        $this->assertEquals('Dream Home', $thing->getName());
    }
}