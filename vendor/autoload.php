<?php

function vendor_autoload($class)
{
  $classFileName = __DIR__ . DIRECTORY_SEPARATOR .str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
  if (file_exists($classFileName)) {
  	include_once $classFileName;
  }
}

spl_autoload_register('vendor_autoload');