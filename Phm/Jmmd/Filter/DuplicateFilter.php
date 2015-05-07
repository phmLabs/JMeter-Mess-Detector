<?php
namespace Phm\Jmmd\Filter;
use Phm\Jmmd\JMeter\HttpSampleElement;
use Phm\Jmmd\Rule\Rule;

class DuplicateFilter
{

    private $rulesForUrls = array();

    public function isFiltered (HttpSampleElement $httpSampleElement, Rule $rule)
    {
        if (array_key_exists($httpSampleElement->getUrl(), $this->rulesForUrls) &&
                 array_key_exists(get_class($rule), $this->rulesForUrls[$httpSampleElement->getUrl()])) {
            return true;
        }
        $this->rulesForUrls[$httpSampleElement->getUrl()][get_class($rule)] = true;
        return false;
    }
}