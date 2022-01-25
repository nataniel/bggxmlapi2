<?php
namespace Nataniel\BoardGameGeek\Boardgame;

class Expansion extends Link
{
    public function isInbound(): bool
    {
        return $this->root['inbound'] === 'true';
    }
}