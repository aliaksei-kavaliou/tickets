<?php

namespace App\Model\Inventory;

use App\Model\Inventory\ItemInterface;

/**
 * Item
 *
 * @author aliaksei
 */
class Item implements ItemInterface
{
    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var \DateTime
     */
    protected $startDate;

    /**
     * Set title
     * @param string $title
     * @return Item
     */
    public function setTitle($title): Item
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set type
     * @param string $type
     * @return Item
     */
    public function setType($type): Item
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set start date
     * @param \DateTime $startDate
     * @return Item
     */
    public function setStartDate(\DateTime $startDate): Item
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }
}
