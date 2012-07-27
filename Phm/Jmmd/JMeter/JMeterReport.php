<?php
namespace Phm\Jmmd\JMeter;

class JMeterReport
{

    private $httpSampleElements;

    public static function createByJtlFile ($filename)
    {
        $jMeterReport = new self();

        $dom = new \DOMDocument();
        $dom->load($filename);

        $jMeterReport->addHttpSampleElementsByDom($dom);

        return $jMeterReport;
    }

    public function addHttpSampleElement ($httpSampleElement)
    {
        $this->httpSampleElements[] = $httpSampleElement;
    }

    private function addHttpSampleElementsByDom ($dom)
    {
        $xpath = new \DOMXPath($dom);
        $httpSampleNodeList = $xpath->query("/testResults/httpSample");

        $elements = array();

        foreach ($httpSampleNodeList as $httpSampleDomElement) {
            $httpSampleElement = new HttpSampleElement();
            $httpSampleElement->setElapsedTime($httpSampleDomElement->getAttribute('t'));
            $httpSampleElement->setReturnCode(((int) $httpSampleDomElement->getAttribute('rc')));
            $httpSampleElement->setUrl((string) $httpSampleDomElement->getElementsByTagName('java.net.URL')
                ->item(0)->nodeValue);

            $this->addHttpSampleElement($httpSampleElement);
        }
    }

    public function getHttpSampleElements ()
    {
        return $this->httpSampleElements;
    }
}