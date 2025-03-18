<?php

namespace Util;

use Error;
use Exception;

class Csv
{
  public string $src;
  public array $lines;
  public array $parsed;

  function __construct(string $file)
  {
    try {
      if (!file_exists($file)) throw new Exception("No file: $file.");
      if (pathinfo($file, PATHINFO_EXTENSION) !== "csv") throw new Exception("Invalid csv: $file.");

      $fd = fopen($file, "r");
      $this->src = file_get_contents($file);

      while ($line = fgetcsv($fd)) {
        $this->lines[] = $line;
      }

      $headings = $this->lines[0];
      $datas = array_slice($this->lines, 1);
      foreach ($datas as $k => &$data) {
        foreach ($data as $j => &$elem) {
          $this->parsed[$headings[$j]][$k] = $elem;
        }
      }
    } catch (Exception | Error $err) {
      error($err);
    }
  }
}