<?php

namespace Phm\Jmmd\JMeter;

class HttpSampleElement
{
  private $elapsedTime;
  private $url;

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
}