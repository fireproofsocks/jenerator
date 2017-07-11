<?php

namespace Jenerator\Command;

use Jenerator\Generators\GeneratorBuilderInterface;
use Jenerator\Jenerator;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowExampleJsonFromSchemaCommand extends Command
{
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


        //$output->writeln($input->getArgument('schema'));

        // ...
        $j = new Jenerator($this->serviceContainer->make(JsonDecoderInterface::class), $this->serviceContainer->make(JsonSchemaAccessorInterface::class), $this->serviceContainer->make(GeneratorBuilderInterface::class));

        $x = $j->main($input->getArgument('schema'));

        $output->writeln(json_encode($x));
    }
}