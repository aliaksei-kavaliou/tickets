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
        $typeStorage->expects($this->exactly(3))->method('getPrice')->willReturn(70);

        $adapter = new RecordAdapter($typeStorage);

        $item = $this->createMock(ItemInterface::class);
        $item->method('getName')->willReturn('cats');
        $item->method('getType')->willReturn('musical');
        $item->method('getStartDate')->willReturn(new \DateTime('2017-06-01'));

        $result = $adapter->makeRecord($item, new \DateTime('2017-07-01'), new \DateTime('2017-08-01'));
        $this->assertTrue($result instanceof RecordInterface);
        $this->assertEquals(0, $result->getItemsAvailable());
        $this->assertEquals(200, $result->getItemsLeft());
        $this->assertEquals('cats', $result->getTitle());
        $this->assertEquals(70, $result->getPrice());
        $this->assertEquals('sale not started', $result->getStatus());

        $result1 = $adapter->makeRecord($item, new \DateTime('2017-08-02'), new \DateTime('2017-08-25'));
        $this->assertEquals(5, $result1->getItemsAvailable());
        $this->assertEquals(90, $result1->getItemsLeft());
        $this->assertEquals(70, $result1->getPrice());

        $result2 = $adapter->makeRecord($item, new \DateTime('2017-09-02'), new \DateTime('2017-09-25'));
        $this->assertEquals(56, $result2->getPrice());
    }
}
