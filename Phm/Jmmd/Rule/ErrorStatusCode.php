<?php
namespace Phm\Jmmd\Rule;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Result\Result;

class ErrorStatusCode implements Rule
{
    private $errorUrls = array();

    public function detect (HttpSampleElement $httpSampleElement)
    {
        if ($httpSampleElement->getReturnCode() == 500) {
            if (! array_key_exists($httpSampleElement->getUrl(),
                    $this->errorUrls)) {
                $this->errorUrls[$httpSampleElement->getUrl()] = true;
                return new Result(false, 'Status Code 500.');
            }
        }
        return new Result(true);
    }
}