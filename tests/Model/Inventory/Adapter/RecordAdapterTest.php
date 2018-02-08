<?php

namespace App\Tests\Model\Inventory\Adapter;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Model\Inventory\Adapter\RecordAdapter;
use App\Model\Inventory\ItemInterface;
use App\Model\Inventory\RecordInterface;
use App\Model\Inventory\Storage\TypeStorageInterface;

/**
 * RecordAdapterTest
 *
 * @author aliaksei
 */
class RecordAdapterTest extends KernelTestCase
{
    /**
     * Test makeRecord()
     */
    public function testMakeRecord()
    {
        $typeStorage = $this->createMock(TypeStorageInterface::class);
        $typeStorage->expects($this->exactly(5))->method('getPrice')->willReturn(70);

        $adapter = new RecordAdapter($typeStorage);

        $item = $this->createMock(ItemInterface::class);
        $item->method('getName')->willReturn('cats');
        $item->method('getType')->willReturn('musical');
        $item->method('getStartDate')->willReturn(new \DateTime('2017-06-01'));

        $result = $adapter->makeRecord($item, new \DateTime('2017-07-01'), new \DateTime('2017-01-01'));
        $this->assertTrue($result instanceof RecordInterface);
        $this->assertEquals(0, $result->getItemsAvailable());
        $this->assertEquals(200, $result->getItemsLeft());
        $this->assertEquals('cats', $result->getTitle());
        $this->assertEquals(70, $result->getPrice());
        $this->assertEquals('sale not started', $result->getStatus());

        $result1 = $adapter->makeRecord($item, new \DateTime('2017-08-02'), new \DateTime('2017-08-25'));
        $this->assertEquals(0, $result1->getItemsAvailable());
        $this->assertEquals(0, $result1->getItemsLeft());
        $this->assertEquals(70, $result1->getPrice());
        $this->assertEquals('in the past', $result1->getStatus());

        $result2 = $adapter->makeRecord($item, new \DateTime('2017-09-25'), new \DateTime('2017-09-05'));
        $this->assertEquals(5, $result2->getItemsAvailable());
        $this->assertEquals(75, $result2->getItemsLeft());
        $this->assertEquals(56, $result2->getPrice());
        $this->assertEquals('open for sale', $result2->getStatus());

        $result3 = $adapter->makeRecord($item, new \DateTime('2017-09-25'), new \DateTime('2017-09-25'));
        $this->assertEquals(0, $result3->getItemsAvailable());
        $this->assertEquals(0, $result3->getItemsLeft());
        $this->assertEquals(56, $result3->getPrice());
        $this->assertEquals('sold out', $result3->getStatus());

        $result4 = $adapter->makeRecord($item, new \DateTime('2017-09-14'), new \DateTime('2017-09-08'));
        $this->assertEquals(5, $result4->getItemsAvailable());
        $this->assertEquals(5, $result4->getItemsLeft());
        $this->assertEquals(56, $result4->getPrice());
        $this->assertEquals('open for sale', $result4->getStatus());
    }
}
