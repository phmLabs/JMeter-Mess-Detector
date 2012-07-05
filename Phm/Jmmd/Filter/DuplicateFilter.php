<?php
namespace Phm\Jmmd\Filter;
use Phm\Jmmd\Rule\Rule;

class DuplicateFilter
{

    private $rulesForUrls = array();

    public function isFiltered ($url, Rule $rule)
    {
        if (array_key_exists($url, $this->rulesForUrls) &&
                 array_key_exists(get_class($rule), $this->rulesForUrls[$url])) {
            return true;
        }
        $this->rulesForUrls[$url][get_class($rule)] = true;
        return false;
    }
}