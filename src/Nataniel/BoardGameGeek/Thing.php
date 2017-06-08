<?php
namespace Nataniel\BoardGameGeek;

class Thing
{
    const LANGUAGE_LEVEL_NO_NECESSARY_TEXT = 1, // No necessary in-game text
        LANGUAGE_LEVEL_SOME_NECESSARY_TEXT = 2, // Some necessary text - easily memorized or small crib sheet
        LANGUAGE_LEVEL_MODERATE_TEXT = 3,       // Moderate in-game text - needs crib sheet or paste ups
        LANGUAGE_LEVEL_EXTENSIVE_USE = 4,       // Extensive use of text - massive conversion needed to be playable
        LANGUAGE_LEVEL_UNPLAYABLE = 5;          // Unplayable in another language

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

    /**
     * @return int
     */
    public function getLanguageDependenceLevel()
    {
        $level = null;
        if ($xml = $this->root->xpath("poll[@name='language_dependence']/results/result")) {

            $maxVotes = 0;
            foreach ($xml as $element) {
                if ((int)$element['numvotes'] > $maxVotes) {
                    $level = (int)$element['level'];
                }
            }

        }

        return $level;
    }

    /**
     * @return int
     */
    public function getBoardgameBasegame()
    {
        $xml = $this->root->xpath("link[@type='boardgameexpansion'][@inbound='true']");
        while(list( , $node) = each($xml)) {
            return (int)$node['id'];
        }

        return null;
    }
}