<?php

namespace App\Tests\Model\Inventory\Storage;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Model\Inventory\Storage\ItemStorage;

/**
 * ItemStorageTest
 *
 * @author aliaksei
 */
class ItemStorageTest extends KernelTestCase
{
    use \App\Tests\Traits\DataSourceTrait;

    /**
     * Test getItems()
     */
    public function testGetItems()
    {
        $storage = new ItemStorage(self::$inputFile);
        $result1 = $storage->getItems(new \DateTime('2017-07-01'));

        $cnt1 = 0;
        $flag1 = false;
        foreach ($result1 as $item) {
            if ('Everyman' === $item->getName()) {
                $flag1 = true;
            }

            $cnt1++;
        }

        $this->assertEquals(2, $cnt1);
        $this->assertFalse($flag1, 'Everyman show not started yet');

        $result2 = $storage->getItems(new \DateTime('2017-08-15'));

        $cnt2 = 0;
        $flag2 = false;
        foreach ($result2 as $item) {
            if ('Everyman' === $item->getName()) {
                $flag2 = true;
            }

            $cnt2++;
        }

        $this->assertEquals(3, $cnt2);
        $this->assertTrue($flag2, 'Everyman show already started');

        $result3 = $storage->getItems(new \DateTime('2017-07-01'), 'musical');

        $cnt3 = 0;
        $flag3 = false;
        foreach ($result3 as $item) {
            if ('Cats' === $item->getName()) {
                $flag3 = true;
            }

            $cnt3++;
        }

        $this->assertEquals(1, $cnt3);
        $this->assertTrue($flag3, 'Cats show expected');

        $result4 = $storage->getItems(new \DateTime('2017-10-01'), 'musical');

        $cnt4 = 0;
        foreach ($result4 as $item) {
            $cnt4++;
        }

        $this->assertEquals(0, $cnt4, 'No show expected');
    }

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $data = [
            ['Cats', '2017-06-01', 'musical'],
            ['Comedy of errors', '2017-07-01', 'comedy'],
            ['Everyman', '2017-08-01', 'drama'],
        ];

        self::loadData($data);
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        self::unlinkDataFile();
    }
}
