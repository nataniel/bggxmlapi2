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

    public function getId(): int
    {
        return (int)$this->root['id'];
    }

    public function getType(): string
    {
        return (string)$this->root['type'];
    }

    public function isType(string $type): bool
    {
        return $this->getType() === $type;
    }

    public function getName(): string
    {
        return (string)$this->root->name['value'];
    }

    public function getYearPublished(): int
    {
        return (int)$this->root->yearpublished['value'];
    }
}