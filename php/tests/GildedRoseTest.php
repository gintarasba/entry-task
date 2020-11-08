<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Entity\AgeingItem;
use GildedRose\Entity\DegradingItem;
use GildedRose\Entity\ItemInterface;
use GildedRose\Entity\PersistingItem;
use GildedRose\Entity\SpecialCaseItem;
use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{

    /**
     * @dataProvider criticalDayPointProvider
     * @param ItemInterface $item
     * @param int $expectedQuality
     */
    public function testQualityIncreaseByDay(ItemInterface $item, int $expectedQuality)
    {
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame($expectedQuality, $item->getItem()->quality);
    }


    public function testDayDegradation()
    {
        $expectedDay = 18;
        $items = [new SpecialCaseItem(new Item('foo', 20, 50))];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $gildedRose->updateQuality();
        $this->assertSame($expectedDay, $items[0]->getItem()->sell_in);
    }

    public function testQualityWillNotDecreaseBelow0()
    {
        $expectedQuality = 0;
        $items = [new DegradingItem(new Item('foo', 20, $expectedQuality))];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame($expectedQuality, $items[0]->getItem()->quality);
    }

    public function testQualityWillNotIncreaseAbove50()
    {
        $expectedQuality = 50;
        $items = [new AgeingItem(new Item('Aged Brie', 20, $expectedQuality))];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame($expectedQuality, $items[0]->getItem()->quality);
    }

    /**
     * @dataProvider providerQualityIncreasingItems
     * @param Item $item
     */
    public function testQualityIncreases(ItemInterface $item)
    {
        $expectedQuality = $item->getItem()->quality + 1;
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertSame($expectedQuality, $item->getItem()->quality);
    }

    /**
     * @dataProvider providerQualityDegradingItems
     * @param Item $item
     */
    public function testQualityDegrade(ItemInterface $item)
    {
        $expectedQuality = $item->getItem()->quality - 1;
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertSame($expectedQuality, $item->getItem()->quality);
    }

    /**
     * @dataProvider providerQualityPersistingItems
     * @param Item $item
     */
    public function testQualityPersist(ItemInterface $item)
    {
        $expectedQuality = $item->getItem()->quality;
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertSame($expectedQuality, $item->getItem()->quality);
    }

    public function criticalDayPointProvider()
    {
        return [
            [
                new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 10, 30)),
                32
            ],
            [
                new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 5, 30)),
                33
            ],
            [
                new AgeingItem(new Item('Aged Brie', 5, 30)),
                31
            ],
        ];
    }

    public function providerQualityDegradingItems()
    {
        return [
            [
                new DegradingItem(new Item('foo', 20, 50)),
            ],
        ];
    }

    public function providerQualityPersistingItems()
    {
        return [
            [
                new PersistingItem(new Item('Sulfuras, Hand of Ragnaros', 20, 40)),
            ],
        ];
    }

    public function providerQualityIncreasingItems()
    {
        return [
            [
                new AgeingItem(new Item('Aged Brie', 20, 40)),
            ],
            [
                new SpecialCaseItem(new Item('Backstage passes to a TAFKAL80ETC concert', 20, 40)),
            ]
        ];
    }

}
