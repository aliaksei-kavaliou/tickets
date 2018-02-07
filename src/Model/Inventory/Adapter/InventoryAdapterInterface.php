<?php

namespace App\Model\Inventory\Adapter;

use App\Model\Inventory\InventoryInterface;
use \App\Model\Inventory\RecordInterface;

/**
 * InventoryAdapterInterface
 * @author aliaksei
 */
interface InventoryAdapterInterface
{
    /**
     * Creates Inventory instance
     * @param string $type
     * @return Inventory
     */
    public function makeInventory($type);

    /**
     * Adds inventory record
     * @param InventoryInterface $inventory
     * @param RecordInterface    $record
     * @return Inventory
     */
    public function addRecord(InventoryInterface $inventory, RecordInterface $record);
}
