<?php

namespace Jenerator\Command;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Jenerator;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppendExamplesToSchemaCommand extends Command
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
            ->setName('example:append')
            ->setDescription('Appends example(s) of JSON values to the given schema whose structure is defined by the given JSON Schemaj')
            ->addArgument('schema', InputArgument::REQUIRED, 'JSON Schema location (path or URL)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$output->writeln($input->getArgument('schema'));

        // ...
        $j = new Jenerator($this->serviceContainer->make(JsonDecoderInterface::class), $this->serviceContainer->make(JsonSchemaAccessorInterface::class), $this->serviceContainer->make(GeneratorFactoryInterface::class));

        $x = $j->main($input->getArgument('schema'));

        $output->writeln(json_encode($x));
    }
}