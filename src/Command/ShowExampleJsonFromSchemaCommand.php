<?php

namespace Jenerator\Command;

use Jenerator\Generators\GeneratorFactoryInterface;
use Jenerator\Jenerator;
use Jenerator\JsonDecoder\JsonDecoderInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorFactoryInterface;
use Jenerator\JsonSchemaAccessor\JsonSchemaAccessorInterface;
use Jenerator\ServiceContainerInterface;
use Jenerator\UseCases\GetExampleJsonFromSchemaInterface;
use Pimple\Container;
use Psr\Log\LoggerInterface;
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


        $output->writeln($input->getArgument('schema'));

        $useCase = $this->serviceContainer->make(GetExampleJsonFromSchemaInterface::class);

        $decoder = $this->serviceContainer->make(JsonDecoderInterface::class);

        $schema = $decoder->decodeFile($input->getArgument('schema'));

        $example = $useCase->getExampleValueFromSchema($schema);

        $output->writeln(json_encode($example));
        return;
        // ...
        $decoder = $this->serviceContainer->make(JsonDecoderInterface::class);

        $schema = $decoder->decodeFile($input->getArgument('schema'));

        $accessor = $this->serviceContainer->make(JsonSchemaAccessorFactoryInterface::class)->getJsonSchemaAccessor($schema);

        //$this->serviceContainer->make(GeneratorFactoryInterface::class)

//        $j = new Jenerator($this->serviceContainer->make(JsonDecoderInterface::class), $this->serviceContainer->make(JsonSchemaAccessorInterface::class), $this->serviceContainer->make(GeneratorFactoryInterface::class));
//
//        $x = $j->main($input->getArgument('schema'));
//
//        $output->writeln(json_encode($x));
    }
}