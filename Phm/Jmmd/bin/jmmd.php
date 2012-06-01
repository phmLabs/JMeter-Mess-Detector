<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatter;

use Phm\Jmmd\Jmmd;
use Phm\Jmmd\JMeter\JMeterReport;
use Phm\Jmmd\Rule\ElapsedTimeRule;
use Phm\Jmmd\Report\TextReport;

include_once __DIR__ . "/autoload.php";

$console = new Application();
$console->register("analyze")
    ->setDefinition(
        array(new InputArgument('inputFileName', InputArgument::REQUIRED, 'JMeter report file'),
              new InputArgument('outputFileName', InputArgument::REQUIRED, 'xUnit output file'),
        		  new InputArgument('maxElapsedTime', InputArgument::OPTIONAL, 'Max elapsed time', '200'),
        		))->setDescription("Analyzing a JMeter log file.")
    ->setHelp("Analyzing a JMeter log file.")
    ->setCode(function (InputInterface $input, OutputInterface $output)
    {
      runAnalyzer($input, $output);
    });

$console->run();

function runAnalyzer(InputInterface $input, OutputInterface $output)
{
  $output->writeln("Analyzing " . $input->getArgument('inputFileName'));

  $JMeterReport = new JMeterReport($input->getArgument('inputFileName'));

  $jmmd = new Jmmd();
  $jmmd->addRule(new ElapsedTimeRule($input->getArgument('maxElapsedTime')));

  $violations = $jmmd->detect($JMeterReport);

  $textReport = new TextReport();

  file_put_contents($input->getArgument('outputFileName'), $textReport->createReport($violations));

  if (count($violations) > 0)
  {
  	$output->writeln("<error>".count($violations)." violations found.</error>");
    exit(1);
  }
  else
  {
  	$output->writeln("<info>No violations found.</info>");
  	exit(0);
  }
}