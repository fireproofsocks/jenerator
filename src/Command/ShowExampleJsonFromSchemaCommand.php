<?php

namespace Jenerator\Command;

use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\Generators\ValueFromSchemaInterface;
use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowExampleJsonFromSchemaCommand extends Command
{
    /**
     * @var Container
     */
    protected $serviceContainer;

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('example:show')
            ->setDescription('Show a randomly generated JSON value whose structure is defined by a JSON Schema')
            ->addArgument('schema', InputArgument::REQUIRED, 'JSON Schema location (path or URL)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $useCase = $this->serviceContainer->make(ValueFromSchemaInterface::class);

        $decoder = $this->serviceContainer->make(JsonDecoderInterface::class);

        $schema = $decoder->decodeFile($input->getArgument('schema'));

        $example = $useCase->getExampleValueFromSchema($schema);

        $output->writeln(json_encode($example, JSON_PRETTY_PRINT));

    }
}