<?php
namespace Nataniel\BoardGameGeek\Collection;

class Item
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    public function getObjectType(): string
    {
        return (string)$this->root['objecttype'];
    }

    public function getObjectId(): int
    {
        return (int)$this->root['objectid'];
    }

    public function getSubtype(): string
    {
        return (string)$this->root['subtype'];
    }

    public function getCollId(): int
    {
        return (int)$this->root['collid'];
    }

    public function getName(): string
    {
        return (string)$this->root->name;
    }

    public function getYearPublished(): int
    {
        return (int)$this->root->yearpublished;
    }

    public function getImage(): string
    {
        return (string)$this->root->image;
    }

    public function getThumbnail(): string
    {
        return (string)$this->root->thumbnail;
    }

    public function getStatus(): \SimpleXMLElement
    {
        return $this->root->status;
    }

    public function getNumPlays(): int
    {
        return (int)$this->root->numplays;
    }
}