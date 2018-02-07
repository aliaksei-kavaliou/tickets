<?php

namespace App\Model\Inventory\Storage;

/**
 * Type storage implementation
 *
 * @author aliaksei
 */
class TypeStorage implements TypeStorageInterface
{
    /**
     * @var array
     */
    private $types = [
        'musical' => 70,
        'comedy' => 50,
        'drama' => 40,
    ];

    /**
     * Constructor
     * @param array $types
     */
    public function __construct(array $types = [])
    {
        $this->types = array_merge($this->types, $types);
    }

    /**
     * Returns type price
     * @param string $type
     * @return float
     */
    public function getPrice($type): float
    {
        return $this->types[$type] ?? null;
    }

    /**
     * Returns available types
     * @return array
     */
    public function getTypes(): array
    {
        return array_keys($this->types);
    }
}
