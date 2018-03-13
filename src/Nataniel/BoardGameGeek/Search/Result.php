<?php
namespace Nataniel\BoardGameGeek\Search;

use Nataniel\BoardGameGeek\Client;
use Nataniel\BoardGameGeek\Thing;

class Result
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int)$this->root['id'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return (string)$this->root['type'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->root->name['value'];
    }

    /**
     * @return int
     */
    public function getYearPublished()
    {
        return (int)$this->root->yearpublished['value'];
    }
}