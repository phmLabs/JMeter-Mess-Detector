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

    private $rules = array();
    private $filters = array();

    public function __construct(array $configFile)
    {
        $rules = $configFile["Rules"];

        $filters = $configFile["Filters"];

        if (is_null($filters)) $filters = array();
        if (is_null($rules)) $rules = array();

        foreach ($rules as $rule) {
            $ruleClassName = $rule["class"];
            $this->rules[] = new $ruleClassName($rule["parameters"]);
        }

        foreach ($filters as $filter) {
            $filterClassName = $filter["class"];
            $this->filters[] = new $filterClassName($filter["parameters"]);
        }

        $reporterName = $configFile["Reporter"]["class"];

        $parameters = $configFile["Reporter"]["Parameters"];
        if (is_null($parameters)) {
            $parameters = array();
        }

        $this->reporter = new $reporterName($parameters);
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function getReporter()
    {
        return $this->reporter;
    }
}