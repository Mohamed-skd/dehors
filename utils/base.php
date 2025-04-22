<?php
// LOGGERS 
function logInfo(string $message)
{
  echo "\nℹ️  $message ℹ️\n";
}
function logSuccess(string $message)
{
  echo "\n✅ $message ✅\n";
}
function logError(string $message)
{
  echo "\n❌ $message ❌\n";
}
function detailLog($detail)
{
  print_r($detail);
}
function errorLog(Exception|Error $error)
{
  logError("Oups ! An error occured 😔");
  print_r($error);
  return false;
}