<?php
namespace Nataniel\BoardGameGeek;

class User
{
    /** @var \SimpleXMLElement */
    private $root;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->root = $xml;
    }

    public function getId()
    {
        return (int)$this->root['id'];
    }

    public function getLogin()
    {
        return (string)$this->root['name'];
    }

    public function getName()
    {
        return trim($this->getFirstName() . ' ' . $this->getLastName());
    }

    public function getFirstName()
    {
        return (string)$this->root->firstname['value'];
    }

    public function getLastName()
    {
        return (string)$this->root->lastname['value'];
    }

    public function getAvatar()
    {
        return (string)$this->root->avatarlink['value'];
    }

    public function getCountry()
    {
        return (string)$this->root->country['value'];
    }
}