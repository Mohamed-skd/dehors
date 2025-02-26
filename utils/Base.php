<?php
// LOGGERS 
function dump(mixed $elem, ?string $name = null)
{
  echo "\n\nℹ️ {$name}:\n";
  var_dump($elem);
  echo "\n";
}
function todo(string $info)
{
  echo "\n❕ À faire: $info\n";
  return false;
}
function scream(string $exp)
{
  throw new Exception($exp);
}
function error(Exception|Error $err)
{
  echo "\n❌ Oups ! An error occured 😔.\n";
  print_r($err);
  echo "\n";
  return false;
}