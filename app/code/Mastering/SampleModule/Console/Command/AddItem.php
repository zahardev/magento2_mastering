<?php

namespace Mastering\SampleModule\Console\Command;

use Magento\Framework\Console\Cli;
use Mastering\SampleModule\Model\Config;
use Symfony\Component\Console\Command\Command;
use Mastering\SampleModule\Model\ItemFactory;
use Mastering\SampleModule\Model\ResourceModel\Item as ResourceItem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddItem extends Command
{
    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_DESCRIPTION = 'description';

    private $itemFactory;
    private $resourceItem;
    private $config;

    public function __construct(ItemFactory $itemFactory, ResourceItem $resourceItem, Config $config)
    {
        $this->itemFactory = $itemFactory;
        $this->resourceItem = $resourceItem;
        $this->config = $config;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('mastering:item:add')
            ->addArgument(
                self::INPUT_KEY_NAME,
                InputArgument::REQUIRED,
                'Item name'
            )->addArgument(
                self::INPUT_KEY_DESCRIPTION,
                InputArgument::OPTIONAL,
                'Item description'
            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if($this->config->isEnabled()){
            $item = $this->itemFactory->create(); /** @var $item \Mastering\SampleModule\Model\Item */

            $item->setName($input->getArgument(self::INPUT_KEY_NAME));
            $item->setDescription($input->getArgument(self::INPUT_KEY_DESCRIPTION));

            try{
                $this->resourceItem->save($item);
            } catch (\Exception $e) {
                return Cli::RETURN_FAILURE;
            }

            return Cli::RETURN_SUCCESS;
        }
    }
}