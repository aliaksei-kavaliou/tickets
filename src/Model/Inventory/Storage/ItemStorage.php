<?php

namespace App\Model\Inventory\Storage;

use App\Model\Inventory\Item;

/**
 * Item storage implementation
 *
 * @author aliaksei
 */
class ItemStorage implements ItemStorageInterface
{
    const AVAILABILITY_DAYS_FROM_THE_START = 100;

    /**
     * Source file path
     * @var string
     */
    private $sourceFile;

    /**
     * Constructor
     * @param string $sourceFile Path to file
     */
    public function __construct($sourceFile = null)
    {
        $this->sourceFile = $sourceFile;
    }

    /**
     * Set data source file
     * @param string $sourceFile
     * @return ItemStorage
     */
    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;

        return $this;
    }

   /**
     * {@inheritdoc}
     */
    public function getItems(\DateTime $requiredDate, $type = null): \Generator
    {
        if (!file_exists($this->sourceFile)) {
            throw new \Exception('No data file');
        }

        $handle = fopen($this->sourceFile, 'rb');

        if (false === $handle) {
            throw new \Exception('Data file error');
        }

        while ($row = fgetcsv($handle)) {
            if ($type && $type != strtolower(trim($row[2]))) {
                continue;
            }

            $startDate = new \DateTime($row[1]);
            $endDate = clone $startDate;
            $endDate->modify('+ '.self::AVAILABILITY_DAYS_FROM_THE_START.' days');

            if ($requiredDate < $startDate || $requiredDate > $endDate) {
                continue;
            }

            $item = new Item();
            $item->setTitle($row[0])
                ->setStartDate($startDate)
                ->setType($type);

            yield $item;
        }
    }
}
