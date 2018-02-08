<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Model\Inventory\Storage\ItemStorage;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Description of InventoryControllerTest
 *
 * @author aliaksei
 */
class InventoryControllerTest extends WebTestCase
{
    use \App\Tests\Traits\DataSourceTrait;

    /**
     * Test index
     */
    public function testIndex()
    {
        $client = self::createClient();
        $this->injectDataFile($client);
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($crawler->filterXPath('//input[@id="filter_requiredDate"]'));
        $this->assertCount(3, $crawler->filterXPath('//h1[contains(@class, "genre")]'));
        $this->assertCount(0, $crawler->filterXPath('//table/tbody/tr[contains(@class, "items")]'));

        $client1 = self::createClient();
        $this->injectDataFile($client1);
        $crawler1 = $client1->request('POST', '/', ['filter' => ['requiredDate' => '2017-07-08']]);
        $this->assertEquals(200, $client1->getResponse()->getStatusCode());
        $this->assertCount(2, $crawler1->filterXPath('//table/tbody/tr[contains(@class, "items")]'));
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

    /**
     * Inject data file to client service
     * @param Client $client
     */
    private function injectDataFile(Client $client)
    {
        /* @var $inventory \App\Service\Inventory */
        $inventory = $client->getContainer()->get('inventory_service');
        $storage = new ItemStorage(self::$inputFile);
        $inventory->setInventoryStorage($storage);
    }
}
