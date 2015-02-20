<?php
/**
 * Created by PhpStorm.
 * User: langn
 * Date: 20.02.15
 * Time: 14:52
 */

namespace Phm\Jmmd\Config;

use Symfony\Component\Yaml\Yaml;

class Configuration
{

    private $rules;
    private $filters;

    public function __construct(array $configFile)
    {
        $rules = $configFile["Rules"];

        $filters = $configFile["Filters"];

        foreach ($rules as $rule) {
            $ruleClassName = $rule["class"];
            $this->rules[] = new $ruleClassName($rule["parameters"]);
        }

        foreach ($filters as $filter) {
            $filterClassName = $filter["class"];
            $this->filters[] = new $filterClassName($filter["parameters"]);
        }
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getRules()
    {
        return $this->rules;
    }
}