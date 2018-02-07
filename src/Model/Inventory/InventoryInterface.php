<?php

namespace App\Model\Inventory;

/**
 * Inventory interface
 * @author aliaksei
 */
interface InventoryInterface
{
    /**
     * Returns inventory type
     * @return string
     */
    public function getType();

    /**
     * Returns inventory records
     * @return array|RecordInterface[]
     */
    public function getRecords();
}
