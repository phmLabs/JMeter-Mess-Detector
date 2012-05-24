<?php

namespace Phm\Jmmd;

use Phm\Jmmd\Rule\Rule;
use Phm\Jmmd\JMeter\JMeterReport;

class Jmmd
{
  private $rules = array();

  public function detect(JMeterReport $report)
  {
  	$violations = array();

    $httpSampleElements = $report->getHttpSampleElements();
    foreach ($httpSampleElements as $httpSampleElement)
    {
      foreach ($this->rules as $rule)
      {
        $result = $rule->detect($httpSampleElement);
        if( !$result->isSuccessful()) {
        	$violations[$httpSampleElement->getUrl()][] = $result;
        }
      }
    }

    return $violations;
  }

  public function addRule(Rule $rule)
  {
    $this->rules[] = $rule;
  }
}
