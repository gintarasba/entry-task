<?php

declare(strict_types=1);

namespace GildedRose\Entity;

use GildedRose\Item;

class AgeingItem implements ItemInterface
{
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function calculateQuality()
    {
        if ($this->item->quality + 1 <= 50) {
            $this->item->quality ++;
        } else {
            $this->item->quality = 50;
        }

        $this->item->sell_in--;

        if ($this->item->sell_in < 0 && $this->item->quality < 50) {
            $this->item->quality++;
        }
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