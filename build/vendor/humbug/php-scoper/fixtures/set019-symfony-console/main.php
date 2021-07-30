<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\PhpParser\NodeDumper;
use SMTP2GOWPPlugin\PhpParser\ParserFactory;
use SMTP2GOWPPlugin\Symfony\Component\Console\Application;
use SMTP2GOWPPlugin\Symfony\Component\Console\Command\Command;
use SMTP2GOWPPlugin\Symfony\Component\Console\Input\InputInterface;
use SMTP2GOWPPlugin\Symfony\Component\Console\Output\OutputInterface;
require_once __DIR__ . '/vendor/autoload.php';
class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this->setName('hello:world')->setDescription('Outputs \'Hello World\'');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world!');
    }
}
\class_alias('SMTP2GOWPPlugin\\HelloWorldCommand', 'HelloWorldCommand', \false);
$command = new HelloWorldCommand();
$application = new Application();
$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();
