<?php

declare(strict_types=1);

namespace GildedRose\Entity;

use GildedRose\Item;

interface ItemInterface
{
    public function calculateQuality();

    public function getItem(): Item;
}