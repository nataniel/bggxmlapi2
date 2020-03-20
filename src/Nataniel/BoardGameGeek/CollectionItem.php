<?php
namespace Nataniel\BoardGameGeek;

class CollectionItem
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return (string)$this->root['objecttype'];
    }

    /**
     * @return string
     */
    public function getObjectId()
    {
        return (int)$this->root['objectid'];
    }

    /**
     * @return string
     */
    public function getSubtype()
    {
        return (string)$this->root['subtype'];
    }

    /**
     * @return string
     */
    public function getCollId()
    {
        return (int)$this->root['collid'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->root->name;
    }

    /**
     * @return int
     */
    public function getYearPublished()
    {
        return (int)$this->root->yearpublished;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return (string)$this->root->image;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return (string)$this->root->thumbnail;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getStatus()
    {
        return $this->root->status;
    }

    /**
     * @return int
     */
    public function getNumPlays()
    {
        return (int)$this->root->numplays;
    }
}