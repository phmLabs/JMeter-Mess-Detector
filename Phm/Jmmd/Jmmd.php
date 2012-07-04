<?php
namespace Phm\Jmmd;
use Phm\Jmmd\Rule\Rule;
use Phm\Jmmd\JMeter\JMeterReport;

class Jmmd
{

    private $rules = array();

    public function detect (JMeterReport $report, $filterDuplicates = true)
    {
        $violations = array();

        $httpSampleElements = $report->getHttpSampleElements();
        foreach ($httpSampleElements as $httpSampleElement) {
            foreach ($this->rules as $rule) {
                if (! $filterDuplicates ||
                         ! array_key_exists($httpSampleElement->getUrl(),
                                $violations) || ! array_key_exists(
                                get_class($rule),
                                $violations[$httpSampleElement->getUrl()])) {
                    $result = $rule->detect($httpSampleElement);
                    if (! $result->isSuccessful()) {
                        $violations[$httpSampleElement->getUrl()][get_class(
                                $rule)][] = $result;
                    }
                }
            }
        }

        return $violations;
    }

    public function addRule (Rule $rule)
    {
        $this->rules[] = $rule;
    }
}