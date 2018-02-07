<?php

namespace App\Tests\Model\Inventory\Adapter;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Model\Inventory\Adapter\InventoryAdapter;
use App\Model\Inventory\Inventory;
use App\Model\Inventory\InventoryInterface;
use App\Model\Inventory\RecordInterface;

/**
 * InventoryAdapterTest
 *
 * @author aliaksei
 */
class InventoryAdapterTest extends KernelTestCase
{
    /**
     * Test makeInventory()
     */
    public function testMakeInventory()
    {
        $adapter = new InventoryAdapter();
        $result = $adapter->makeInventory('comedy');

        $this->assertTrue($result instanceof InventoryInterface);
        $this->assertEquals('comedy', $result->getType());
    }

    /**
     * Test addRecord
     */
    public function testAddRecord()
    {
        $inventory = new Inventory();
        $adapter = new InventoryAdapter();

        $this->assertCount(0, $inventory->getRecords());
        $adapter->addRecord($inventory, $this->createMock(RecordInterface::class));
        $this->assertCount(1, $inventory->getRecords());
    }
}
