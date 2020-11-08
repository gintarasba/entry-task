<?php

declare(strict_types=1);

namespace GildedRose\Entity;

use GildedRose\Item;

class PersistingItem implements ItemInterface
{
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function calculateQuality()
    {
    }

    public function __toString()
    {
        return $this->item->__toString();
    }

    public function getItem(): Item
    {
        return $this->item;
    }
}