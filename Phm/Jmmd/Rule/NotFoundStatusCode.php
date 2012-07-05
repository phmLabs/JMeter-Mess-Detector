<?php
namespace Phm\Jmmd\Rule;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Result\Result;

class NotFoundStatusCode implements Rule
{

    private $errorUrls = array();

    public function detect (HttpSampleElement $httpSampleElement)
    {
        if ($httpSampleElement->getReturnCode() == 404) {
            return new Result(false, 'Status Code 404.');
        }
        return new Result(true);
    }
}