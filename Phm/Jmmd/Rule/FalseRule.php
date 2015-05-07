<?php
namespace Phm\Jmmd\Rule;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Result\Result;

class FalseRule implements Rule
{

    public function detect (HttpSampleElement $httpSampleElement)
    {
        static $count = 0;
        var_dump( $count++);
        return new Result(false, "This rule always returns false");
    }
}