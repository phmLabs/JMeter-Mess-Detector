<?php

namespace Phm\Jmmd\JMeter\Normalizer;

use Phm\Jmmd\JMeter\JMeterReport;

class Normalizer
{
	public function getNormalizedReport( JMeterReport $report) {
		$normalizedReport = new JMeterReport();
		$httpSampleElements = $report->getHttpSampleElements();
		foreach ( $httpSampleElements as $httpSampleElement ) {
			$newHttpSampleElement = clone $httpSampleElement;
			$url = $httpSampleElement->getUrl();
			$url = preg_replace("#cp=[0-9]*#", "cp=1", $url);
			$newHttpSampleElement->setUrl($url);
			$normalizedReport->addHttpSampleElement($newHttpSampleElement);
		}
		return $normalizedReport;
	}
}