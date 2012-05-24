<?php

namespace Phm\Jmmd\Rule;

use Phm\Jmmd\JMeter\HttpSampleElement;

interface Rule
{
  public function detect(HttpSampleElement $httpSampleElement);
}