<?php

namespace Func;

use Exception;

class FileFn
{
  function getEnv(string $env = ".env")
  {
    if (!file_exists($env)) throw new Exception("No .env file: $env.");

    $datas = [];
    $envFile = file($env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($envFile as $line) {
      if (str_starts_with($line, "#"))
        continue;

      $tabline = explode("=", $line);
      $key = trim($tabline[0]);
      $value = trim($tabline[1]);
      if (str_starts_with($value, "#"))
        continue;

      $datas[$key] = $value;
    }

    return $datas;
  }

  function getDir(string $dir)
  {
    if (!file_exists($dir)) throw new Exception("No dir: $dir.");
    return array_map(fn($name) => "$dir/$name", array_values(array_diff(scandir($dir), [".", ".."])));
  }

  function loadJson(string $file)
  {
    if (!file_exists($file)) throw new Exception("No file: $file.");
    if (pathinfo($file, PATHINFO_EXTENSION) !== "json") throw new Exception("Invalid json: $file.");

    $fileContent = file_get_contents($file);
    return json_decode($fileContent, true);
  }

  function downFile(string $file, string $filename = "data.json", string $type = "application/json")
  {
    if (!file_exists($file)) throw new Exception("Invalid file: $file.");
    header("content-disposition:attachment; filename=$filename");
    header("content-type:$type");
    readfile($file);
    exit;
  }
}