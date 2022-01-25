<?php
namespace Nataniel\BoardGameGeek\Boardgame;

use Nataniel\BoardGameGeek\Exception;

abstract class Link
{
    const
        TYPE_CATEGORY = 'boardgamecategory',
        TYPE_MECHANIC = 'boardgamemechanic',
        TYPE_EXPANSION = 'boardgameexpansion',
        TYPE_DESIGNER = 'boardgamedesigner',
        TYPE_ARTIST = 'boardgameartist',
        TYPE_PUBLISHER = 'boardgamepublisher';

    /** @var \SimpleXMLElement */
    protected $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    public function getId(): int
    {
        return (int)$this->root['id'];
    }

    public function getType(): int
    {
        return (string)$this->root['type'];
    }

    public function getName(): string
    {
        return (string)$this->root['value'];
    }

    public function toString(): string
    {
        return $this->getName();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function factory(\SimpleXMLElement $xml): Link
    {
        switch ($xml['type']) {
            case self::TYPE_ARTIST:    return new Artist($xml);
            case self::TYPE_DESIGNER:  return new Designer($xml);
            case self::TYPE_PUBLISHER: return new Publisher($xml);
            case self::TYPE_EXPANSION: return new Expansion($xml);
            case self::TYPE_CATEGORY:  return new Category($xml);
            case self::TYPE_MECHANIC:  return new Mechanic($xml);
            default:
                throw new Exception(sprintf('Invalid link type: %s.', $xml['type']));
        }
    }
}