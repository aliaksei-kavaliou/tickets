<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use App\Command\InventoryCommand;

/**
 * InventoryCommandTest
 *
 * @author aliaksei
 */
class InventoryCommandTest extends KernelTestCase
{
    use \App\Tests\Traits\DataSourceTrait;

    /**
     * @var Application
     */
    private $application;

    /**
     * Test command execute
     */
    public function testExecute()
    {
        /* @var $command InventoryCommand  */
        $command = $this->application->find('app:get-inventory');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            'input-file' => self::$inputFile,
            'required-date' => '2017-07-01',
            'query-date' => '2017-01-01',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('"inventory":', $output);
        $this->assertContains('sale not started', $output);
        $this->assertNotContains('open for sale', $output);
        $this->assertNotContains('in the past', $output);
        $this->assertContains('"title": "Cats"', $output);
        $this->assertNotContains('"title": "Everyman"', $output);

        $commandTester->execute([
            'command' => $command->getName(),
            'input-file' => self::$inputFile,
            'required-date' => '2017-08-15',
            'query-date' => '2017-08-01',
        ]);

        $output1 = $commandTester->getDisplay();
        $this->assertNotContains('sale not started', $output1);
        $this->assertNotContains('in the past', $output1);
        $this->assertContains('open for sale', $output1);
        $this->assertContains('"title": "Everyman"', $output1);

        $commandTester->execute([
            'command' => $command->getName(),
            'input-file' => self::$inputFile,
            'required-date' => '2017-08-15',
            'query-date' => '2018-08-01',
        ]);

        $output2 = $commandTester->getDisplay();
        $this->assertNotContains('sale not started', $output2);
        $this->assertNotContains('open for sale', $output2);
        $this->assertContains('in the past', $output2);
        $this->assertContains('"title": "Everyman"', $output2);
    }

    /**
     * Test execute command bad input
     */
    public function testExecuteBadInput()
    {
        /* @var $command InventoryCommand  */
        $command = $this->application->find('app:get-inventory');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'input-file' => 'dummy file name',
            'required-date' => '2017-01-01',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Input file error', $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $this->application = new Application($kernel);
        $this->application->add(new InventoryCommand($kernel->getContainer()->get('inventory_service')));
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
