<?php
namespace Nataniel\BoardGameGeek;

/**
 * Class Client
 * @package Nataniel\BoardGameGeek
 * https://boardgamegeek.com/wiki/page/BGG_XML_API2
 */
class Client
{
    const API_URL = 'https://www.boardgamegeek.com/xmlapi2';
    const TYPE_RPGITEM = 'rpgitem',
        TYPE_VIDEOGAME = 'videogame',
        TYPE_BOARDGAME = 'boardgame',
        TYPE_BOARDGAMEACCESSORY = 'boardgameaccessory',
        TYPE_BOARDGAMEEXPANSION = 'boardgameexpansion';

    /**
     * @param  int $id
     * @param  bool $stats
     * @return Thing
     * @throws Exception
     */
    public function getThing($id, $stats)
    {
        $filename = sprintf('%s/thing?id=%d&stats=%d', self::API_URL, $id, $stats);
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        return new Thing($xml);
    }

    /**
     * @param  string $name
     * @return User
     * @throws Exception
     */
    public function getUser($name)
    {
        $filename = sprintf('%s/user?name=%s', self::API_URL, $name);
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        return new User($xml);
    }

    /**
     * @param  string $query
     * @param  bool $exact
     * @param  string|null $type
     * @return Search\Query|Search\Result[]
     */
    public function search($query, $exact = false, $type = self::TYPE_BOARDGAME)
    {
        $filename = sprintf('%s/search?%s', self::API_URL, http_build_query(array_filter([
            'query' => $query,
            'type' => $type,
            'exact' => (int)$exact,
        ])));

        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        return new Search\Query($xml);
    }
}
