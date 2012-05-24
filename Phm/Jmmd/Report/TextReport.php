<?php

namespace Phm\Jmmd\Report;

class TextReport
{
  public function createReport(array $results)
  {
    $resultMessage = "";

    foreach ($results as $url => $resultForUrl)
    {
      foreach ($resultForUrl as $result)
      {
        $resultMessage .= $url . " - " . $result->getMessage() . "\n";
      }
    }

    return $resultMessage;
  }
}