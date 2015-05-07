<?php
namespace Phm\Jmmd;

use Phm\Jmmd\Rule\Rule;
use Phm\Jmmd\JMeter\JMeterReport;

class Jmmd
{

    private $rules = array();

    private $filters = array();

    public function detect(JMeterReport $report, $filterDuplicates = true)
    {
        $violations = array();

        $httpSampleElements = $report->getHttpSampleElements();

        foreach ($httpSampleElements as $httpSampleElement) {
            foreach ($this->rules as $rule) {
                if (!$this->isFiltered($httpSampleElement, $rule)) {
                    $result = $rule->detect($httpSampleElement);
                    if (!$result->isSuccessful()) {
                        $violations[$httpSampleElement->getUrl()][get_class($rule)][] = $result;
                    }
                }
            }
        }

        return $violations;
    }

    private function isFiltered($url, $rule)
    {
        foreach ($this->filters as $filter) {
            if ($filter->isFiltered($url, $rule)) {
                return true;
            }
        }
        return false;
    }

    public function addFilter($filter)
    {
        $this->filters[] = $filter;
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }
}