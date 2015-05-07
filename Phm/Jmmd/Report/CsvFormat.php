<?php
namespace Phm\Jmmd\Report;

class CsvFormat
{

    public function __construct(array $parameters = array())
    {
        $this->output = $parameters["output"];
    }

    public function createReport (array $results)
    {
        $resultMessage = "url;rule;message\n";

        foreach ($results as $url => $rulesWithViolations) {
            foreach ($rulesWithViolations as $rule => $violations) {
                foreach ($violations as $violation) {
                    $resultMessage .= '"' . $url . '";' . $rule . ";" .
                             $violation->getMessage() . "\n";
                }
            }
        }

        return file_put_contents($this->output, $resultMessage);
    }
}