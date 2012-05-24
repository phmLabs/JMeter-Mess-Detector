<?php

namespace Phm\Jmmd\Result;

class Result
{
  private $isSuccessful;

  private $message;

  public function __construct($isSuccessful, $message = "")
  {
    $this->isSuccessful = $isSuccessful;
    $this->message = $message;
  }

  public function isSuccessful()
  {
    return $this->isSuccessful;
  }

  public function getMessage()
  {
    return $this->message;
  }
}
