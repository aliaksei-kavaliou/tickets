<?php

namespace App\Model\Inventory\Adapter;

use App\Model\Inventory\Adapter\InventoryAdapterInterface;
use App\Model\Inventory\Inventory;
use App\Model\Inventory\RecordInterface;
use App\Model\Inventory\InventoryInterface;

/**
 * InventoryAdapter. Creates Inventory object and adds inventory records.
 *
 * @author aliaksei
 */
class InventoryAdapter implements InventoryAdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function addRecord(InventoryInterface $inventory, RecordInterface $record): Inventory
    {
        /* @var $inventory Inventory */
        $inventory->addShow($record);

        return $inventory;
    }

    /**
     * {@inheritdoc}
     */
    public function makeInventory($type): Inventory
    {
        $inventory = new Inventory();
        $inventory->setGenre($type);

        return $inventory;
    }
}
