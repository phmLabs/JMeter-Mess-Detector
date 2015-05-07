<?php

namespace Phm\Jmmd\Result;

use Phm\Jmmd\JMeter\HttpSampleElement;

class Result
{
    private $isSuccessful;

    private $message;

    private $httpSampleElement;

    public function __construct($isSuccessful, $message = "")
    {
        $this->isSuccessful = $isSuccessful;
        $this->message = $message;
    }

    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setHttpSampleElement(HttpSampleElement $httpSampleElement)
    {
        $this->httpSampleElement = $httpSampleElement;
    }

    public function getHttpSampleElement()
    {
        return $this->httpSampleElement;
    }
}
