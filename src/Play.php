<?php
namespace Nataniel\BoardGameGeek;

class Play
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return (string) $this->root['date'];
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return (int) $this->root['quantity'];
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return (string) $this->root->item['objecttype'];
    }

    /**
     * @return int
     */
    public function getObjectId()
    {
        return (int) $this->root->item['objectid'];
    }

    /**
     * @return string
     */
    public function getObjectName()
    {
        return (string) $this->root->item['name'];
    }
}
