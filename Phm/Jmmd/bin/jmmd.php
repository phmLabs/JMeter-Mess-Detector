<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Phm\Jmmd\Jmmd;
use Phm\Jmmd\JMeter\JMeterReport;
use Phm\Jmmd\Rule\ElapsedTimeRule;

include_once __DIR__ . "/autoload.php";

$console = new Application();
$console->register("analyze")
    ->setDefinition(
        array(new InputArgument('inputFileName', InputArgument::REQUIRED, 'JMeter report file'),
            new InputArgument('outputFileName', InputArgument::REQUIRED, 'xUnit output file')))->setDescription("Analyzing a JMeter log file.")
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
  $jmmd->addRule(new ElapsedTimeRule(200));

  $violations = $jmmd->detect($JMeterReport);

  $violationMessage = "";

  foreach ($violations as $url => $violationsForUrl)
  {
    foreach ($violationsForUrl as $violation)
    {
      $violationMessage .= $url . " - " . $violation->getMessage() . "\n";
    }
  }

  file_put_contents($input->getArgument('outputFileName'), $violationMessage);

  if (count($violations) > 0)
  {
    exit(1);
  }
}
