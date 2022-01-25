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

    public function getId(): int
    {
        return (int)$this->root['id'];
    }

    public function getRank(): int
    {
        return (int)$this->root['rank'];
    }

    public function getName(): string
    {
        return (string)$this->root->name['value'];
    }

    public function getYearPublished(): int
    {
        return (int)$this->root->yearpublished['value'];
    }

    public function getThumbnail(): string
    {
        return (string)$this->root->thumbnail['value'];
    }
}