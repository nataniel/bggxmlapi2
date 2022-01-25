<?php
namespace Nataniel\BoardGameGeek;

class Thing
{
    const
        LANGUAGE_LEVEL_NO_NECESSARY_TEXT = 1, // No necessary in-game text
        LANGUAGE_LEVEL_SOME_NECESSARY_TEXT = 2, // Some necessary text - easily memorized or small crib sheet
        LANGUAGE_LEVEL_MODERATE_TEXT = 3,       // Moderate in-game text - needs crib sheet or paste ups
        LANGUAGE_LEVEL_EXTENSIVE_USE = 4,       // Extensive use of text - massive conversion needed to be playable
        LANGUAGE_LEVEL_UNPLAYABLE = 5;          // Unplayable in another language

    const
        TYPE_BOARDGAME = 'boardgame',
        TYPE_BOARDGAMEEXPANSION = 'boardgameexpansion',
        TYPE_BOARDGAMEACCESSORY = 'boardgameaccessory',
        TYPE_VIDEOGAME = 'videogame',
        TYPE_RPGITEM = 'rpgitem',
        TYPE_RPGISSUE = 'rpgissue';

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

    public function isBoardgame(): bool
    {
        return $this->isType(self::TYPE_BOARDGAME);
    }

    public function isBoardgameExpansion(): bool
    {
        return $this->isType(self::TYPE_BOARDGAMEEXPANSION);
    }

    public function getName(): string
    {
        return (string)$this->root->name['value'];
    }

    public function getDescription(): string
    {
        return (string)$this->root->description;
    }

    public function getImage(): string
    {
        return (string)$this->root->image;
    }

    public function getThumbnail(): string
    {
        return (string)$this->root->thumbnail;
    }

    public function getYearPublished(): int
    {
        return (int)$this->root->yearpublished['value'];
    }

    public function getMinPlayers(): int
    {
        return (int)$this->root->minplayers['value'];
    }

    public function getMaxPlayers(): int
    {
        return (int)$this->root->maxplayers['value'];
    }

    public function getPlayingTime(): int
    {
        return (int)$this->root->playingtime['value'];
    }

    public function getMinPlayTime(): int
    {
        return (int)$this->root->minplaytime['value'];
    }

    public function getMaxPlayTime(): int
    {
        return (int)$this->root->maxplaytime['value'];
    }

    public function getMinAge(): int
    {
        return (int)$this->root->minage['value'];
    }

    /**
     * @return Boardgame\Category[]
     */
    public function getBoardgameCategories(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamecategory']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Category($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Mechanic[]
     */
    public function getBoardgameMechanics(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamemechanic']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Mechanic($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Designer[]
     */
    public function getBoardgameDesigners(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamedesigner']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Designer($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Artist[]
     */
    public function getBoardgameArtists(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgameartist']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Artist($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Publisher[]
     */
    public function getBoardgamePublishers(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgamepublisher']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Publisher($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Expansion[]
     */
    public function getBoardgameExpansions(): array
    {
        $values = [];
        $xml = $this->root->xpath("link[@type='boardgameexpansion']");
        foreach ($xml as $element) {
            $values[] = new Boardgame\Expansion($element);
        }

        return $values;
    }

    /**
     * @return Boardgame\Link[]
     */
    public function getLinks(): array
    {
        $values = [];
        $xml = $this->root->xpath("link");
        foreach ($xml as $element) {
            $values[] = Boardgame\Link::factory($element);
        }

        return $values;
    }

    public function getRatingAverage(): float
    {
        return round((float)$this->root->statistics->ratings->average['value'], 1);
    }
    
    public function getWeightAverage(): float
    {
        return round((float)$this->root->statistics->ratings->averageweight['value'], 1);
    }

    public function getAlternateNames(): array
    {
        $names = [];
        $xml = $this->root->xpath("name[@type='alternate']");
        foreach ($xml as $element) {
            $names[] = (string)$element['value'];
        }

        return $names;
    }

    public function getLanguageDependenceLevel(): ?int
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

    public function getBoardgameBasegame(): ?Boardgame\Expansion
    {
        foreach ($this->getBoardgameExpansions() as $expansion) {
            if ($expansion->isInbound()) {
                return $expansion;
            }
        }

        return null;
    }
}
