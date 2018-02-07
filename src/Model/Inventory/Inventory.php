<?php

namespace App\Model\Inventory;

use App\Model\Inventory\InventoryInterface;

/**
 * Description of Inventory
 *
 * @author aliaksei
 */
class Inventory implements InventoryInterface, \JsonSerializable
{
    /**
     *
     * @var string
     */
    protected $genre;

    /**
     *
     * @var array
     */
    protected $shows = [];

    /**
     * Adds show to inventory
     * @param \App\Model\Inventory\RecordInterface $record
     */
    public function addShow(RecordInterface $record): void
    {
        $this->shows[] = $record;
    }

    /**
     * Set genre
     * @param string $type
     * @return \App\Model\Inventory\Record
     */
    public function setGenre($type): Record
    {
        $this->genre = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecords(): array
    {
        return $this->shows;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->genre;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return ['genre' => $this->genre, 'shows' => $this->shows];
    }
}
