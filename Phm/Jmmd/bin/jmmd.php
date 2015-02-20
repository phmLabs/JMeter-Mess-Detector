<?php

use Phm\Jmmd\Rule\ForbiddenStatusCode;
use Phm\Jmmd\JMeter\Normalizer\Normalizer;

use Phm\Jmmd\Filter\UrlBlackListFilter;

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
use Symfony\Component\Yaml\Yaml;

include_once __DIR__ . "/autoload.php";

$console = new Application();
$console->register("analyze")
    ->setDefinition(
        array(
            new InputArgument('configFileName', InputArgument::REQUIRED, 'jmmd config file'),
            new InputArgument('inputFileName', InputArgument::REQUIRED, 'JMeter report file'),
            new InputArgument('outputFileName', InputArgument::REQUIRED, 'xUnit output file')))
    ->setDescription("Analyzing a JMeter log file.")
    ->setHelp("Analyzing a JMeter log file.")
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        runAnalyzer($input, $output);
    });

$console->run();

function runAnalyzer(InputInterface $input, OutputInterface $output)
{
    $output->writeln('');
    $output->writeln("Analyzing " . $input->getArgument('inputFileName'));
    $output->writeln('');

    $jmmd = new Jmmd();
    $JMeterReport = JMeterReport::createByJtlFile($input->getArgument('inputFileName'));
    $config = new \Phm\Jmmd\Config\Configuration(Yaml::parse(file_get_contents($input->getArgument('configFileName'))));

    $jmmd->addRules($config->getRules());
    $jmmd->addFilters($config->getFilters());

    $normalizer = new Normalizer();
    $normalizedJMeterReport = $normalizer->getNormalizedReport($JMeterReport);
    unset($JMeterReport);

    $violations = $jmmd->detect($normalizedJMeterReport);

    $textReport = new CsvFormat();

    file_put_contents($input->getArgument('outputFileName'), $textReport->createReport($violations));

    if (count($violations) > 0) {
        $violationCount = 0;
        foreach ($violations as $violations) {
            $violationCount += count($violations);
        }
        $output->writeln("<error>" . $violationCount . " violations found.</error>");
        exit(1);
    } else {
        $output->writeln("  <info> No violations found. </info>");
        $output->writeln('');
        exit(0);
    }
}