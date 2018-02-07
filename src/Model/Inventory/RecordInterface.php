<?php

namespace App\Model\Inventory;

/**
 * RecordInterface
 * @author aliaksei
 */
interface RecordInterface
{
    /**
     * Returns record title
     * @return string
     */
    public function getTitle();

    /**
     * Returns how many items left
     * @return int
     */
    public function getItemsLeft();

    /**
     * Returns how many items available
     * @return int
     */
    public function getItemsAvailable();

    /**
     * Availability status
     * @return string
     */
    public function getStatus();

    /**
     * Returns current price
     * @return float
     */
    public function getPrice();
}
