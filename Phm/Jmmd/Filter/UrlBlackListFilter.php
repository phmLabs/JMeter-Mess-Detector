<?php

namespace Phm\Jmmd\Filter;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Rule\Rule;

class UrlBlackListFilter
{
    private $regularExpressions = array();

    public function __construct(array $parameters)
    {
        $regexes = $parameters["regex"];
        foreach($regexes as $regex) {
            $this->addRegEx($regex);
        }
    }

    public function addRegEx ($regex)
    {
        $this->regularExpressions[] = $regex;
    }

    public function isFiltered (HttpSampleElement $httpSampleElement, Rule $rule)
    {
        foreach ($this->regularExpressions as $regEx) {
        	$resultCount = preg_match($regEx, $httpSampleElement->getUrl());
            if ( $resultCount > 0) {
                return true;
            }
        }
        return false;
    }
}