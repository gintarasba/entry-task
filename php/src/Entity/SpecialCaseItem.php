<?php

declare(strict_types=1);

namespace GildedRose\Entity;

use GildedRose\Item;

class SpecialCaseItem implements ItemInterface
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
        if ($this->item->quality + $this->degradationSpeed <= 50) {
            $this->item->quality += $this->degradationSpeed;

            if ($this->item->sell_in < 11 && $this->item->quality + 1 <= 50) {
                $this->item->quality ++;
            }

            if ($this->item->sell_in < 6 && $this->item->quality + 1 <= 50) {
                $this->item->quality ++;
            }
        } else {
            $this->item->quality = 50;
        }

        $this->item->sell_in--;

        if ($this->item->sell_in < 0 && $this->item->quality < 50) {
            $this->item->quality++;
        }

        if ($this->item->sell_in < 0) {
            $this->item->quality = 0;
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