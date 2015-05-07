<?php
namespace Phm\Jmmd\Filter;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Rule\Rule;

class UrlWhiteListFilter
{
    private $regularExpressions = array();

    public function __construct(array $parameters)
    {
        $regexes = $parameters["regex"];
        foreach($regexes as $regex) {
            $this->addRegEx($regex);
        }
    }

    private function addRegEx ($regex)
    {
        $this->regularExpressions[] = $regex;
    }

    public function isFiltered (HttpSampleElement $httpSampleElement, Rule $rule)
    {
        foreach ($this->regularExpressions as $regEx) {
            if (preg_match($regEx, $httpSampleElement->getUrl()) > 0) {
                return false;
            }
        }
        return true;
    }
}