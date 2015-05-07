<?php
namespace Phm\Jmmd\Filter;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Rule\Rule;

class TimeSlotFilter
{

    private $to;
    private $from;

    public function __construct(array $parameters)
    {
        $this->from = $parameters["from"];
        $this->to = $parameters["to"];
    }

    public function isFiltered (HttpSampleElement $httpSampleElement, Rule $rule)
    {
        $time = $httpSampleElement->getTimeStamp();
        return ($time < $this->from || $time > $this->to);
    }
}