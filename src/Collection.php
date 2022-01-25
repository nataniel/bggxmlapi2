<?php
namespace Nataniel\BoardGameGeek;

class Collection implements \IteratorAggregate, \Countable
{
    /** @var \SimpleXMLElement */
    private $root;

    /** @var Collection\Item[] */
    private $items = [];

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
        foreach ($this->root as $item) {
            $this->items[] = new Collection\Item($item);
        }
    }

    /**
     * @return \ArrayIterator|Collection\Item[]
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return (int)$this->root['totalitems'];
    }
}