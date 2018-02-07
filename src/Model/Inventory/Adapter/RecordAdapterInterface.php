<?php

namespace App\Model\Inventory\Adapter;

/**
 * RecordAdapterInterface
 * Describes Record creation.
 *
 * @author aliaksei
 */
interface RecordAdapterInterface
{
    const STATUS_SALE_NOT_STARTED = "sale not started";
    const STATUS_OPEN_FOR_SALE = "open for sale";
    const STATUS_SOLD_OUT = "sold out";
    const STATUS_IN_THE_PAST = "in the past";

    /**
     * Creates inventory record object from inventory item
     * @param \App\Model\Inventory\ItemInterface $item
     * @param \DateTime                          $requiredDate
     * @param \DateTime                          $queryDate
     * @return \App\Model\Inventory\RecordInterface
     */
    public function makeRecord(\App\Model\Inventory\ItemInterface $item, \DateTime $requiredDate, \DateTime $queryDate);
}
