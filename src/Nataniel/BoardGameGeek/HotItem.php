<?php
namespace Nataniel\BoardGameGeek;

class HotItem
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
    public function getRank()
    {
        return (int)$this->root['rank'];
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

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return (string)$this->root->thumbnail['value'];
    }
}