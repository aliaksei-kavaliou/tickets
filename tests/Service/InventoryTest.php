<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Model\Inventory\Inventory;
use App\Model\Inventory\Adapter\InventoryAdapterInterface;
use App\Model\Inventory\Adapter\RecordAdapterInterface;
use App\Model\Inventory\RecordInterface;
use App\Service\Inventory as InventoryService;
use App\Model\Inventory\Storage\TypeStorageInterface;
use App\Model\Inventory\ItemInterface;
use App\Model\Inventory\Storage\ItemStorageInterface;

/**
 * InventoryTest
 *
 * @author aliaksei
 */
class InventoryTest extends KernelTestCase
{
    /**
     * Test makeInventory
     */
    public function testMakeInventory()
    {
        $item1 = $this->createMock(ItemInterface::class);
        $item2 = $this->createMock(ItemInterface::class);

        $record1 = $this->createMock(RecordInterface::class);
        $record1->method('getTitle')->willReturn('cats');
        $record2 = $this->createMock(RecordInterface::class);
        $record2->method('getTitle')->willReturn('comedy of errors');

        $typeStorage = $this->createMock(TypeStorageInterface::class);
        $typeStorage->method('getTypes')->willReturn(['musical', 'comedy']);

        $inventoryStorage = $this->createMock(ItemStorageInterface::class);
        $inventoryStorage->expects($this->exactly(2))->method('getItems')->will(
            $this->onConsecutiveCalls([$item1], [$item2])
        );

        $inventoryAdapter = $this->createMock(InventoryAdapterInterface::class);
        $inventory1 = new Inventory();
        $inventory2 = new Inventory();

        $inventoryAdapter->expects($this->exactly(2))->method('makeInventory')->will(
            $this->onConsecutiveCalls($inventory1, $inventory2)
        );

        $recordAdapter = $this->createMock(RecordAdapterInterface::class);
        $recordAdapter->expects($this->exactly(2))->method('makeRecord')->will(
            $this->onConsecutiveCalls($record1, $record2)
        );

        $inventoryAdapter->expects($this->exactly(2))->method('addRecord')->will(
            $this->returnCallback(
                function ($inventory, $record) {
                    $inventory->addShow($record);
                }
            )
        );

        $service = new InventoryService($inventoryStorage, $typeStorage, $inventoryAdapter, $recordAdapter);

        $result = $service->makeInventory(new \DateTime());
        $this->assertCount(2, $result);
        $this->assertEquals('cats', $result[0]->getRecords()[0]->getTitle());
        $this->assertEquals('comedy of errors', $result[1]->getRecords()[0]->getTitle());
    }
}
