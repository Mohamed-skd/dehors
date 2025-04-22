<?php

namespace Controller;

use Error;
use Exception;

class Products
{
  public array $list;
  public array $cats = [];

  function __construct(string $file)
  {
    global $fileFn;

    try {
      $this->list = $fileFn->loadJson($file);

      foreach ($this->list as &$prod) {
        $this->cats[$prod["cat"]][] = $prod;
      }
      shuffle($this->list);
    } catch (Exception | Error $err) {
      errorLog($err);
    }
  }

  function getProduct(string $name)
  {
    return array_values(array_filter($this->list, function ($val) use ($name) {
      return str_contains(strtolower($val["name"]), strtolower($name));
    }));
  }
  function getCat(string $cat)
  {
    return $this->cats[$cat] ?? [];
  }
}