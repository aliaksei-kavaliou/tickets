<?php

namespace App\Model\Inventory\Storage;

/**
 * Item storage interface.
 * @author aliaksei
 */
interface ItemStorageInterface
{
    /**
     *
     * @param \DateTime $requiredDate
     * @param string    $type
     *
     * @return iterable|\App\Model\Inventory\ItemInterface[]
     */
    public function getItems(\DateTime $requiredDate, $type = null);
}
