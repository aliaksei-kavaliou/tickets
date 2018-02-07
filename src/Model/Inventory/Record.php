<?php

namespace App\Model\Inventory;

use App\Model\Inventory\RecordInterface;

/**
 * Record
 *
 * @author aliaksei
 */
class Record implements RecordInterface, \JsonSerializable
{
    /**
     *
     * @var int
     */
    protected $itemsAvailable;

    /**
     *
     * @var int
     */
    protected $itemsLeft;

    /**
     *
     * @var float
     */
    protected $price;

    /**
     *
     * @var string
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     * Set items available
     * @param int $itemsAvailable
     * @return \App\Model\Inventory\Record
     */
    public function setItemsAvailable($itemsAvailable): Record
    {
        $this->itemsAvailable = $itemsAvailable;

        return $this;
    }

    /**
     * Set items left
     * @param int $itemsLeft
     * @return \App\Model\Inventory\Record
     */
    public function setItemsLeft($itemsLeft): Record
    {
        $this->itemsLeft = $itemsLeft;

        return $this;
    }

    /**
     * Set price
     * @param float $price
     * @return \App\Model\Inventory\Record
     */
    public function setPrice($price): Record
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Set status
     * @param string $status
     * @return \App\Model\Inventory\Record
     */
    public function setStatus($status): Record
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set title
     * @param string $title
     * @return \App\Model\Inventory\Record
     */
    public function setTitle($title): Record
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsAvailable(): int
    {
        return $this->itemsAvailable;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsLeft(): int
    {
        return $this->itemsLeft;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'tickets left' => $this->itemsLeft,
            'tickets available' => $this->itemsAvailable,
            'status' => $this->status,
        ];
    }
}
