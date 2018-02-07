<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Inventory;
use \App\Model\Inventory\Storage\ItemStorage;

/**
 * Allows you check items availability on concrete date. Print json encoded string
 *
 * @author aliaksei
 */
class InventoryCommand extends Command
{
    const INPUT_ARGUMENT_INPUT_FILE = "input-file";
    const INPUT_ARGUMENT_REQUEST_DATE = "query-date";
    const INPUT_ARGUMENT_REQUIRED_DATE = "required-date";

    /**
     * @var Inventory
     */
    private $inventoryService;

    /**
     * Constructor
     * @param Inventory   $inventoryService
     * @param string|null $name             The name of the command;
     *                                      passing null means it must be set in configure()
     */
    public function __construct(Inventory $inventoryService, $name = null)
    {
        parent::__construct($name);
        $this->inventoryService = $inventoryService;
    }

        /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:get-inventory')
            ->setDescription('Retuns inventory list.')
            ->setHelp('This command allows you check items availability on concrete date')
            ->addArgument(self::INPUT_ARGUMENT_INPUT_FILE, InputArgument::REQUIRED, 'Data source csv file')
            ->addArgument(self::INPUT_ARGUMENT_REQUIRED_DATE, InputArgument::REQUIRED, 'Required date')
            ->addArgument(
                self::INPUT_ARGUMENT_REQUEST_DATE,
                InputArgument::OPTIONAL,
                'Request date. Default is current date',
                'now'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceFile = $input->getArgument(self::INPUT_ARGUMENT_INPUT_FILE);

        if (!file_exists($sourceFile)) {
            $output->writeln('<error>Input file error</error>');

            return 1;
        }

        $requiredDate = new \DateTime($input->getArgument(self::INPUT_ARGUMENT_REQUIRED_DATE));
        $queryDate = new \DateTime($input->getArgument(self::INPUT_ARGUMENT_REQUEST_DATE));

        $inventoryStorage = new ItemStorage($sourceFile);
        $this->inventoryService->setInventoryStorage($inventoryStorage);
        $inventory = $this->inventoryService->makeInventory($requiredDate, $queryDate);

        $output->writeln(json_encode(['inventory' => $inventory], JSON_PRETTY_PRINT));
    }
}
