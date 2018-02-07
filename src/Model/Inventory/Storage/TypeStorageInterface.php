<?php

namespace App\Model\Inventory\Storage;

/**
 *
 * @author aliaksei
 */
interface TypeStorageInterface
{
    /**
     * @return array Type string
     */
    public function getTypes();

    /**
     * Gives price by type
     * @param string $type
     * @return float
     */
    public function getPrice($type);
}
