<?php

namespace App\Service;

use App\Model\Inventory\Storage\ItemStorageInterface;
use App\Model\Inventory\InventoryInterface;
use App\Model\Inventory\Storage\TypeStorageInterface;
use App\Model\Inventory\Adapter\InventoryAdapterInterface;
use App\Model\Inventory\Adapter\RecordAdapterInterface;

/**
 * Description of Inventory
 *
 * @author aliaksei
 */
class Inventory
{
    /**
     *
     * @var InventoryStorageInterface
     */
    private $inventoryStorage;

    /**
     *
     * @var TypeStorageInterface
     */
    private $typeStorage;

    /**
     *
     * @var InventoryAdapter
     */
    private $inventoryAdapter;

    /**
     *
     * @var RecordAdapter
     */
    private $recordAdapter;

    /**
     * Constructor
     * @param InventoryStorageInterface $inventoryStorage
     * @param TypeStorageInterface      $typeStorage
     * @param InventoryAdapter          $inventoryAdapter
     * @param RecordAdapter             $recordAdapter
     */
    public function __construct(
        ItemStorageInterface $inventoryStorage,
        TypeStorageInterface $typeStorage,
        InventoryAdapterInterface $inventoryAdapter,
        RecordAdapterInterface $recordAdapter
    ) {
        $this->inventoryStorage = $inventoryStorage;
        $this->typeStorage = $typeStorage;
        $this->inventoryAdapter = $inventoryAdapter;
        $this->recordAdapter = $recordAdapter;
    }

    /**
     * Set inventory storage
     * @param ItemStorageInterface $inventoryStorage
     * @return Inventory
     */
    public function setInventoryStorage(ItemStorageInterface $inventoryStorage): Inventory
    {
        $this->inventoryStorage = $inventoryStorage;

        return $this;
    }

    /**
     * Set tye storage
     * @param TypeStorageInterface $typeStorage
     * @return Inventory
     */
    public function setTypeStorage(TypeStorageInterface $typeStorage): Inventory
    {
        $this->typeStorage = $typeStorage;

        return $this;
    }


    /**
     * Creates inventory data
     * @param \DateTime $requiredDate
     * @param \DateTime $queryDate
     * @return InventoryInterface[]
     */
    public function makeInventory(\DateTime $requiredDate, \DateTime $queryDate = null): array
    {
        if (!$queryDate) {
            $queryDate = new \DateTime();
        }

        $data = [];
        $types = $this->typeStorage->getTypes();

        foreach ($types as $type) {
            $items = $this->inventoryStorage->getItems($requiredDate, $type);

            /* @var $inventory InventoryInterface */
            $inventory = $this->inventoryAdapter->makeInventory($type);

            foreach ($items as $item) {
                $record = $this->recordAdapter->makeRecord($item, $requiredDate, $queryDate);
                $this->inventoryAdapter->addRecord($inventory, $record);
            }

            $data[] = $inventory;
        }

        return $data;
    }
}
