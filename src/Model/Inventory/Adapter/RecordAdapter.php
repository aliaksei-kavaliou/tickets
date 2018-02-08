<?php

namespace App\Model\Inventory\Adapter;

use App\Model\Inventory\Adapter\RecordAdapterInterface;
use App\Model\Inventory\ItemInterface;
use App\Model\Inventory\Record;
use App\Model\Inventory\Storage\TypeStorageInterface;

/**
 * Description of RecordAdapter
 *
 * @author aliaksei
 */
class RecordAdapter implements RecordAdapterInterface
{
    /**
     *
     * @var TypeStorageInterface
     */
    private $typeStorage;

    /**
     * Adapter configuration parameters
     * @var array
     */
    private $config = [
        'big_hall_capacity' => 200,
        'small_hall_capacity' => 100,
        'switch_hall_after' => 60,
        'set_discount_after' => 80,
        'discount' => 20,
        'sale_start_days_before' => 25,
        'sold_out_days_before' => 5,
    ];

    /**
     * Constructor
     * @param TypeStorageInterface $typeStorage
     * @param array                $config
     */
    public function __construct(TypeStorageInterface $typeStorage, array $config = [])
    {
        $this->typeStorage = $typeStorage;
        $this->config = array_merge($this->config, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function makeRecord(ItemInterface $item, \DateTime $requiredDate, \DateTime $queryDate): Record
    {
        $record = new Record();
        $record->setTitle($item->getName())
            ->setItemsLeft($this->getItemsLeft($item, $requiredDate, $queryDate))
            ->setItemsAvailable($this->getItemsAvailable($item, $requiredDate, $queryDate))
            ->setPrice($this->calculatePrice($item, $requiredDate))
            ->setStatus($this->getStatus($requiredDate, $queryDate));

        return $record;
    }

    /**
     * Calculates how many items left
     * @param ItemInterface $item
     * @param \DateTime     $requiredDate
     * @param \DateTime     $queryDate
     * @return int
     */
    private function getItemsLeft(ItemInterface $item, \DateTime $requiredDate, \DateTime $queryDate): int
    {
        $status = $this->getStatus($requiredDate, $queryDate);

        if (self::STATUS_OPEN_FOR_SALE == $status) {
            $daysBeforeRequired = $requiredDate->diff($queryDate)->days;
            $daysForSale = $daysBeforeRequired - $this->config['sold_out_days_before'];

            return $daysForSale * $this->getDailyLimit($item, $requiredDate);
        }

        if (self::STATUS_SALE_NOT_STARTED == $status) {
            return $this->getHallCapacity($item, $requiredDate);
        }

        return 0;
    }

    /**
     * Calculates available items
     * @param ItemInterface $item
     * @param \DateTime     $requiredDate
     * @param \DateTime     $queryDate
     * @return int
     */
    private function getItemsAvailable(ItemInterface $item, \DateTime $requiredDate, \DateTime $queryDate): int
    {
        $status = $this->getStatus($requiredDate, $queryDate);

        if (self::STATUS_OPEN_FOR_SALE === $status) {
            return $this->getDailyLimit($item, $requiredDate);
        }

        return 0;
    }

    /**
     * Returns hall capacity
     * @param ItemInterface $item
     * @param \DateTime     $requiredDate
     * @return int
     */
    private function getHallCapacity(ItemInterface $item, \DateTime $requiredDate)
    {
        $daysSinceStart = $requiredDate->diff($item->getStartDate())->days;
        $hallCapacity = $daysSinceStart > $this->config['switch_hall_after'] ?
            $this->config['small_hall_capacity'] : $this->config['big_hall_capacity'];

        return $hallCapacity;
    }

    /**
     * Returns daily sell limit
     * @param ItemInterface $item
     * @param \DateTime     $requiredDate
     * @return int
     */
    private function getDailyLimit(ItemInterface $item, \DateTime $requiredDate)
    {
        $hallCapacity = $this->getHallCapacity($item, $requiredDate);
        $dailyLimit = $hallCapacity /
            ($this->config['sale_start_days_before'] - $this->config['sold_out_days_before']);

        return $dailyLimit;
    }

    /**
     * Calculates sale price
     * @param ItemInterface $item
     * @param \DateTime     $requiredDate
     * @return float
     */
    private function calculatePrice(ItemInterface $item, \DateTime $requiredDate): float
    {
        $daysSinceStart = $requiredDate->diff($item->getStartDate())->days;
        $discount = $daysSinceStart > $this->config['set_discount_after'] ? $this->config['discount'] / 100 : 0;
        $itemPrice = $this->typeStorage->getPrice($item->getType());

        return $itemPrice * (1 - $discount);
    }

    /**
     * Determines sale status
     *
     * @param \DateTime $requiredDate
     * @param \DateTime $queryDate
     * @return string
     */
    private function getStatus(\DateTime $requiredDate, \DateTime $queryDate): string
    {
        $daysBeforeRequired = (int)$queryDate->diff($requiredDate)->format("%R%a");

        if ($daysBeforeRequired < 0) {
            return self::STATUS_IN_THE_PAST;
        }

        if ($daysBeforeRequired > $this->config['sale_start_days_before']) {
            return self::STATUS_SALE_NOT_STARTED;
        }

        if ($daysBeforeRequired <= $this->config['sold_out_days_before']) {
            return self::STATUS_SOLD_OUT;
        }

        return self::STATUS_OPEN_FOR_SALE;
    }
}
