<?php

include_once __DIR__ . "/../../../vendor/autoload.php";

function phm_autoload($class)
{
  $classFileName = __DIR__ . "/../../../" . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

  if (file_exists($classFileName))
  {
    include_once $classFileName;
  }
}

spl_autoload_register('phm_autoload');
