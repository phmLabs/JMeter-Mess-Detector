<?php

use Symfony\Component\Console\Application;

include_once __DIR__."/autoload.php";

$jmReportingFile = $_SERVER['argv'][1];
$jmmdOutputFile = $_SERVER['argv'][2];

echo "\nAnalyzing " . $jmReportingFile."\n";

$maxValue = 200;

$dom = new DOMDocument();
$dom->load($jmReportingFile);

$xpath = new DOMXPath($dom);
$httpSampleElements = $xpath->query("/testResults/httpSample");

$violations = array();

foreach ($httpSampleElements as $httpSampleElement)
{
  $timeElapsed = (int) $httpSampleElement->getAttribute('t');
  if ($timeElapsed > $maxValue)
  {
    $urlElements = $httpSampleElement->getElementsByTagName('java.net.URL');
    foreach ($urlElements as $urlElement)
    {
      $url = $urlElement->nodeValue;
    }
    $violations[] = $url . ': too slow. Elaspsed time was ' . $timeElapsed . '.';
  }
}

$errorLog = '';
foreach ($violations as $violation)
{
  $errorLog .= $violation."\n";
}

file_put_contents($jmmdOutputFile, $errorLog);

if ( count($violations)> 0 ) {
	exit(1);
}