<?php

namespace Phm\Jmmd\Filter;
use Phm\Jmmd\Rule\Rule;

class UrlBlackListFilter
{
    private $regularExpressions = array();

    public function addRegEx ($regex)
    {
        $this->regularExpressions[] = $regex;
    }

    public function isFiltered ($url, Rule $rule)
    {
        foreach ($this->regularExpressions as $regEx) {
        	$resultCount = preg_match($regEx, $url);
            if ( $resultCount > 0) {
                return true;
            }
        }
        return false;
    }
}