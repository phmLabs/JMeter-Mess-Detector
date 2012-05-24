<?php

include_once __DIR__."/../../../vendor/autoload.php";

function phm_autoload($class)
{
  $classname = str_replace('\\', DIRECTORY_SEPARATOR, $class);
//   var_dump( $classname );
}

spl_autoload_register('phm_autoload');