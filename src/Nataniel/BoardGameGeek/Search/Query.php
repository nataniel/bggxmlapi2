<?php
namespace Nataniel\BoardGameGeek\Search;

use Nataniel\BoardGameGeek\Exception;

class Query implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /** @var \SimpleXMLElement */
    private $root;

    /** @var Result[] */
    private $results = [];

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;

        foreach ($this->root as $item) {
            $this->results[] = new Result($item);
        }
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }

    /**
     * @return int
     */
    public function count()
    {
        return (int)$this->root['total'];
    }

    /**
     * @param  int $offset
     * @param  mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception('Search\\Query is read-only.');
    }

    /**
     * @param  int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->results[$offset]);
    }

    /**
     * @param int $offset
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('Search\\Query is read-only.');
    }

    /**
     * @param  int $offset
     * @return Result|null
     */
    public function offsetGet($offset)
    {
        return isset($this->results[ $offset ])
            ? $this->results[ $offset ]
            : null;
    }

    /**
     * @return Result[]
     */
    public function toArray()
    {
        return $this->results;
    }
}