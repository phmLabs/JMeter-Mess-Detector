<?php

use Phm\Jmmd\Rule\ForbiddenStatusCode;

use Phm\Jmmd\Rule\NotFoundStatusCode;

use Phm\Jmmd\Filter\UrlWhiteListFilter;

use Phm\Jmmd\Filter\DuplicateFilter;

use Symfony\Component\Console\Input\InputOption;

use Phm\Jmmd\Report\CsvFormat;

use Phm\Jmmd\Rule\ErrorStatusCode;

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
        		  new InputOption('maxElapsedTime', null, InputArgument::OPTIONAL, 'Max elapsed time', '200'),
        		))->setDescription("Analyzing a JMeter log file.")
    ->setHelp("Analyzing a JMeter log file.")
    ->setCode(function (InputInterface $input, OutputInterface $output)
    {
      runAnalyzer($input, $output);
    });

$console->run();

function runAnalyzer(InputInterface $input, OutputInterface $output)
{
  $output->writeln('');
  $output->writeln("Analyzing " . $input->getArgument('inputFileName'));
  $output->writeln('');

  $JMeterReport = new JMeterReport($input->getArgument('inputFileName'));

  $jmmd = new Jmmd();

  $jmmd->addRule(new ForbiddenStatusCode());
  $jmmd->addRule(new ElapsedTimeRule($input->getOption('maxElapsedTime')));
  $jmmd->addRule(new ErrorStatusCode());
  $jmmd->addRule(new NotFoundStatusCode());

  $jmmd->addFilter(new DuplicateFilter());
  $whiteListFilter = new UrlWhiteListFilter();
  $whiteListFilter->addRegEx("#\/\d+\/[^\/]+\.html(\?.+)?$#");
  $whiteListFilter->addRegEx("#_\d+\.html(\?.+)?$#");
  $whiteListFilter->addRegEx("#^(\/syndication\/mobile\_feed\.php|\/video\/bc_feed.php|\/rss\/(gala_rss|beauty)\.html)(\?.+)?$#" );
  $jmmd->addFilter($whiteListFilter);

  $violations = $jmmd->detect($JMeterReport);

  $textReport = new CsvFormat();

  file_put_contents($input->getArgument('outputFileName'), $textReport->createReport($violations));

  if (count($violations) > 0)
  {
  	$output->writeln("  <error> ".count($violations)." violations found. </error>");
  	$output->writeln('');
    exit(1);
  }
  else
  {
  	$output->writeln("  <info> No violations found. </info>");
  	$output->writeln('');
  	exit(0);
  }
}