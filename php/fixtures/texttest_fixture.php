<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\Entity\AgeingItem;
use GildedRose\Entity\DegradingItem;
use GildedRose\Entity\PersistingItem;
use GildedRose\Entity\SpecialCaseItem;
use GildedRose\GildedRose;
use GildedRose\Item;

echo "OMGHAI!" . PHP_EOL;

$items = array(
    new DegradingItem(new Item('+5 Dexterity Vest', 10, 20)),
    new AgeingItem(new Item('Aged Brie', 2, 0)),
    new DegradingItem(new Item('Elixir of the Mongoose', 5, 7)),
    new PersistingItem(new Item('Sulfuras, Hand of Ragnaros', 0, 80)),
    new PersistingItem(new Item('Sulfuras, Hand of Ragnaros', -1, 80)),
    new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20)),
    new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49)),
    new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49)),
    // this conjured item does not work properly yet
    new DegradingItem(new Item('Conjured Mana Cake', 3, 6), 2)
);

$app = new GildedRose($items);

$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("-------- day $i --------" . PHP_EOL);
    echo("name, sellIn, quality" . PHP_EOL);
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
