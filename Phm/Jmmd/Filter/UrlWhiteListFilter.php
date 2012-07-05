<?php
namespace Phm\Jmmd\Filter;
use Phm\Jmmd\Rule\Rule;

class UrlWhiteListFilter
{
    private $regularExpressions = array();

    public function addRegEx ($regex)
    {
        $this->regularExpressions[] = $regex;
    }

    public function isFiltered ($url, Rule $rule)
    {
        foreach ($this->regularExpressions as $regEx) {
            if (preg_match($regEx, $url) > 0) {
                return false;
            }
        }
        return true;
    }
}