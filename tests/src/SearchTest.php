<?php
namespace Nataniel\BoardGameGeekTest;

use PHPUnit\Framework\TestCase;
use Nataniel\BoardGameGeek;

class SearchTest extends TestCase
{
    public function testQuery()
    {
        $xml = simplexml_load_file(__DIR__ . '/../files/search.xml');
        $search = new BoardGameGeek\Search\Query($xml);
        $this->assertCount(82, $search);
        $this->assertInstanceOf(\Traversable::class, $search);
    }
}