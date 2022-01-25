<?php
namespace Nataniel\BoardGameGeek;

class Factory
{
    public static function fromXml(\SimpleXMLElement $item): ?Thing
    {
        if (empty($item['type'])) {
            return null;
        }

        switch ($item['type']) {
            case Thing::TYPE_BOARDGAME:
            case Thing::TYPE_BOARDGAMEEXPANSION:
                return new Boardgame($item);
            default:
                return new Thing($item);
        }
    }
}