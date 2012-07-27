<?php
namespace Phm\Jmmd\Rule;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Result\Result;

class ForbiddenStatusCode implements Rule
{

    private $errorUrls = array();

    public function detect (HttpSampleElement $httpSampleElement)
    {
        if ($httpSampleElement->getReturnCode() == 403) {

            return new Result(false, 'Status Code 403.');
        }
        return new Result(true);
    }
}