<?php

declare(strict_types=1);

namespace GildedRose\Entity;

use GildedRose\Item;

class DegradingItem implements ItemInterface
{
    private $item;
    private $degradationSpeed;

    public function __construct(Item $item, $degradationSpeed = 1)
    {
        $this->item = $item;
        $this->degradationSpeed = $degradationSpeed;
    }

    public function calculateQuality()
    {
        if ($this->item->quality - $this->degradationSpeed >= 0) {
            $this->item->quality -= $this->degradationSpeed;
        } else {
            $this->item->quality = 0;
        }

        $this->item->sell_in--;

        if ($this->item->sell_in < 0) {
            if ($this->item->quality - $this->degradationSpeed >= 0) {
                $this->item->quality -= $this->degradationSpeed;
            } else {
                $this->item->quality = 0;
            }
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