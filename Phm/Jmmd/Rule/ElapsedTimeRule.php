<?php

namespace Phm\Jmmd\Rule;

use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Result\Result;

class ElapsedTimeRule implements Rule
{
  private $maxValue;

  public function __construct($maxValue = 200)
  {
    $this->maxValue = $maxValue;
  }

  public function detect(HttpSampleElement $httpSampleElement)
  {
    if ($httpSampleElement->getElapsedTime() > $this->maxValue)
    {
      return new Result(false, 'Elapsed time ' . $httpSampleElement->getElapsedTime() .
      		                     "ms was greater than defined maximum of " . $this->maxValue . "ms.");
    }
    else
    {
      return new Result(true);
    }
  }
}