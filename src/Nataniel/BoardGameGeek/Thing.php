<?php
namespace Nataniel\BoardGameGeek;

class Thing
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml->item;
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
    public function getName()
    {
        return (string)$this->root->name['value'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->root->description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return (string)$this->root->image;
    }

    /**
     * @return int
     */
    public function getYearPublished()
    {
        return (int)$this->root->yearpublished['value'];
    }

    /**
     * @return int
     */
    public function getMinPlayers()
    {
        return (int)$this->root->minplayers['value'];
    }

    /**
     * @return int
     */
    public function getMaxPlayers()
    {
        return (int)$this->root->maxplayers['value'];
    }

    /**
     * @return int
     */
    public function getPlayingTime()
    {
        return (int)$this->root->playingtime['value'];
    }

    /**
     * @return int
     */
    public function getMinPlayTime()
    {
        return (int)$this->root->minplaytime['value'];
    }

    /**
     * @return int
     */
    public function getMaxPlayTime()
    {
        return (int)$this->root->maxplaytime['value'];
    }

    /**
     * @return int
     */
    public function getMinAge()
    {
        return (int)$this->root->minage['value'];
    }

    /**
     * @return string[]
     */
    public function getBoardgameCategories()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamecategory']");
        foreach ($xml as $element) {
            $values[] = (string)$element['value'];
        }

        return $values;
    }

    /**
     * @return string[]
     */
    public function getBoardgameMechanics()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamemechanic']");
        foreach ($xml as $element) {
            $values[] = (string)$element['value'];
        }

        return $values;
    }

    /**
     * @return string[]
     */
    public function getBoardgameDesigners()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamedesigner']");
        foreach ($xml as $element) {
            $values[] = (string)$element['value'];
        }

        return $values;
    }

    /**
     * @return string[]
     */
    public function getBoardgameArtists()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgameartist']");
        foreach ($xml as $element) {
            $values[] = (string)$element['value'];
        }

        return $values;
    }

    /**
     * @return string[]
     */
    public function getBoardgamePublishers()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamepublisher']");
        foreach ($xml as $element) {
            $values[] = (string)$element['value'];
        }

        return $values;
    }

    /**
     * @return int[]
     */
    public function getBoardgameExpansions()
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgameexpansion']");
        foreach ($xml as $element) {
            if ($element['inbound'] != 'true') {
                $values[] = (int)$element['id'];
            }
        }

        return $values;
    }

    /**
     * @return float
     */
    public function getRatingAverage()
    {
        return round((float)$this->root->statistics->ratings->average['value'], 1);
    }

    /**
     * @return string[]
     */
    public function getAlternateNames()
    {
        $names = [];
        $xml = $this->root->xpath("name[@type='alternate']");
        foreach ($xml as $element) {
            $names[] = (string)$element['value'];
        }

        return $names;
    }
}