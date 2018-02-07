<?php

namespace App\Model\Inventory;

/**
 * ItemInterface represents inventory item
 *
 * @author aliaksei
 */
interface ItemInterface
{
    /**
     * Returns item name
     * @return string
     */
    public function getName();

    /**
     * Returns item type
     * @return string
     */
    public function getType();

    /**
     * Returns item start date
     * @return \DateTime
     */
    public function getStartDate();
}
