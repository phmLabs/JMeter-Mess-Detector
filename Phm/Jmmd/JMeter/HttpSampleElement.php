<?php
namespace Phm\Jmmd\JMeter;

class HttpSampleElement
{

    private $elapsedTime;

    private $url;

    private $returnCode;

    private $timestamp;

    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setElapsedTime($elapsedTime)
    {
        $this->elapsedTime = $elapsedTime;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
    }

    public function getReturnCode()
    {
        return $this->returnCode;
    }

    public function getTimeStamp()
    {
        return $this->timestamp;
    }

    public function setTimeStamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }
}