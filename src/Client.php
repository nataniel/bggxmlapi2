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

    public function getThing(int $id, bool $stats = false): ?Thing
    {
        $xml = $this->request('thing', [
            'id' => $id,
            'stats' => $stats,
        ]);

        return Factory::fromXml($xml->item);
    }

    /**
     * @return Thing[]
     */
    public function getThings(array $ids, bool $stats = false): array
    {
        $xml = $this->request('thing', [
            'id' => join(',', $ids),
            'stats' => $stats,
        ]);

        $items = [];
        foreach ($xml as $item) {
            $items[] = Factory::fromXml($item);
        }

        return $items;
    }

    /**
     * https://boardgamegeek.com/wiki/page/BGG_XML_API2#toc11
     * TODO: Note that you should check the response status code... if it's 202 (vs. 200) then it indicates BGG has queued
     * your request and you need to keep retrying (hopefully w/some delay between tries) until the status is not 202.
     * @return Collection|Collection\Item[]
     */
    public function getCollection(array $params): Collection
    {
        $xml = $this->request('collection', $params);
        if ($xml->getName() != 'items') {
            throw new Exception($xml->error->message);
        }

        return new Collection($xml);
    }

    /**
     * @return HotItem[]
     */
    public function getHotItems(string $type = Type::BOARDGAME): array
    {
        $xml = $this->request('hot', [
            'type' => $type,
        ]);

        $items = [];
        foreach ($xml as $item) {
            $items[] = new HotItem($item);
        }

        return $items;
    }

    public function getUser(string $name): ?User
    {
        $xml = $this->request('user', [
            'name' => $name
        ]);

        return !empty($xml['id'])
            ? new User($xml)
            : null;
    }

    /**
     * @return Search\Query|Search\Result[]
     */
    public function search(string $query, bool $exact = false, string $type = Type::BOARDGAME): Search\Query
    {
        $xml = $this->request('search', array_filter([
            'query' => $query,
            'type' => $type,
            'exact' => (int)$exact,
        ]));

        return new Search\Query($xml);
    }

    /**
     * @return Play[]
     */
    public function getPlays(array $params): array
    {
        $xml = $this->request('plays', $params);

        $items = [];
        foreach ($xml as $item) {
            $items[] = new Play($item);
        }

        return $items;
    }

    protected function request(string $action, array $params = []): \SimpleXMLElement
    {
        $url = sprintf('%s/%s?%s', self::API_URL, $action, http_build_query($params));
        $xml = simplexml_load_file($url);
        if (!$xml instanceof \SimpleXMLElement) {
            throw new Exception('API call failed');
        }

        return $xml;
    }
}
