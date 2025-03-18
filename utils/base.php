<?php
// LOGGERS 
function dump(mixed $var, ?string $name = null)
{
  echo "\n\nℹ️ {$name}:\n";
  var_dump($var);
  echo "\n";
}
function todo(string $info)
{
  echo "\n❕ À faire: $info\n";
  return false;
}
function error(Exception|Error $err)
{
  echo "\n❌ Oups ! An error occured 😔.\n";
  print_r($err);
  echo "\n";
  return false;
}