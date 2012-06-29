<?php

namespace Phm\Jmmd\JMeter;

class JMeterReport
{
  private $domDocument;

  public function __construct($filename)
  {
    $this->domDocument = new \DOMDocument();
    $this->domDocument->load($filename);
  }

  public function getHttpSampleElements()
  {
    $xpath = new \DOMXPath($this->domDocument);
    $httpSampleNodeList = $xpath->query("/testResults/httpSample");

    $elements = array();

    foreach ($httpSampleNodeList as $httpSampleDomElement)
    {
      $httpSampleElement = new HttpSampleElement();
      $httpSampleElement->setElapsedTime($httpSampleDomElement->getAttribute('t'));
      $httpSampleElement->setReturnCode(((int)$httpSampleDomElement->getAttribute('rc')));
      $httpSampleElement->setUrl((string)$httpSampleDomElement->getElementsByTagName('java.net.URL')->item(0)->nodeValue);

      $elements[] = $httpSampleElement;
    }

    return $elements;
  }
}