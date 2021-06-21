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

    /**
     * @param  int $id
     * @param  bool $stats
     * @return Thing
     * @throws Exception
     */
    public function getThing($id, $stats = false)
    {
        $filename = sprintf('%s/thing?id=%d&stats=%d', self::API_URL, $id, $stats);
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        return new Thing($xml->item);
    }

    /**
     * @param  int[] $ids
     * @param  bool $stats
     * @return Thing[]
     * @throws Exception
     */
    public function getThings($ids, $stats = false)
    {
        $filename = sprintf('%s/thing?id=%s&stats=%d', self::API_URL, join(',', $ids), $stats);
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        $items = [];
        foreach ($xml as $item) {
            $items[] = new Thing($item);
        }

        return $items;
    }

    /**
     * https://boardgamegeek.com/wiki/page/BGG_XML_API2#toc11
     * TODO: Note that you should check the response status code... if it's 202 (vs. 200) then it indicates BGG has queued
     * your request and you need to keep retrying (hopefully w/some delay between tries) until the status is not 202.
     * @param  array $params
     * @return CollectionItem[]
     * @throws Exception
     */
    public function getCollection($params)
    {
        $filename = sprintf('%s/collection?%s', self::API_URL, http_build_query($params));
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        $items = [];
        foreach ($xml as $item) {
            $items[] = new CollectionItem($item);
        }

        return $items;
    }

    /**
     * @param  string $type
     * @return HotItem[]
     * @throws Exception
     */
    public function getHotItems($type = Type::BOARDGAME)
    {
        $filename = sprintf('%s/hot?type=%s', self::API_URL, $type);
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        $items = [];
        foreach ($xml as $item) {
            $items[] = new HotItem($item);
        }

        return $items;
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
     * @throws Exception
     */
    public function search($query, $exact = false, $type = Type::BOARDGAME)
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

    /**
     * @param  array $params
     * @return Play[]
     * @throws Exception
     */
    public function getPlays($params)
    {
        $filename = sprintf('%s/plays?%s', self::API_URL, http_build_query($params));
        $xml = simplexml_load_file($filename);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        $items = [];
        foreach ($xml as $item) {
            $items[] = new Play($item);
        }

        return $items;
    }
}
