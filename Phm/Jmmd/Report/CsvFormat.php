<?php
namespace Phm\Jmmd\Report;

class CsvFormat
{

    public function createReport (array $results)
    {
        $resultMessage = "";

        foreach ($results as $url => $rulesWithViolations) {
            foreach ($rulesWithViolations as $rule => $violations) {
                foreach ($violations as $violation) {
                    $resultMessage .= '"'.$url . '";' . $rule . ";" . $violation->getMessage() . "\n";
                }
            }
        }
        return $resultMessage;
    }
}