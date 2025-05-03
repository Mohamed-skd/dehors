<?php

namespace Lib;

use Error;
use Exception;

class Csv
{
  public string $content;
  public array $lines;
  public array $parsed;

  function __construct(string $file)
  {
    try {
      if (!file_exists($file)) throw new Exception("No file: $file.");
      if (pathinfo($file, PATHINFO_EXTENSION) !== "csv") throw new Exception("Invalid csv: $file.");

      $fd = fopen($file, "r");
      $this->content = file_get_contents($file);
      if (!$this->content) throw new Exception("Error while getting file content");

      while ($line = fgetcsv($fd)) {
        $this->lines[] = $line;
      }

      $headings = $this->lines[0];
      $datas = array_slice($this->lines, 1);
      foreach ($datas as $i => &$data) {
        foreach ($data as $j => &$elem) {
          $this->parsed[$headings[$j]][$i] = $elem;
        }
      }

      fclose($fd);
    } catch (Exception | Error $err) {
      errorLog($err);
    }
  }
}