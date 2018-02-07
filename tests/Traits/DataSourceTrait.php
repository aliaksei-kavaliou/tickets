<?php
namespace App\Tests\Traits;

/**
 * Helper to test file dependents logic
 * @author aliaksei
 */
trait DataSourceTrait
{
    /**
     * @var string
     */
    protected static $inputFile;

    /**
     * Creates temp file for test purpose
     * @param array $data
     * @param strin $prefix
     */
    protected static function loadData(array $data, $prefix = '')
    {
        self::$inputFile = tempnam(sys_get_temp_dir(), $prefix);
        $handler = fopen(self::$inputFile, 'wb');

        foreach ($data as $row) {
            fputcsv($handler, $row);
        }

        fclose($handler);
    }

    /**
     * Removes temp file
     */
    protected static function unlinkDataFile()
    {
        if (file_exists(self::$inputFile)) {
            unlink(self::$inputFile);
        }
    }
}
