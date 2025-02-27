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
      return error($err);
    }
  }

  function getProduct(string $id)
  {
    return array_filter($this->list, function ($val) use ($id) {
      return $val["id"] === $id;
    })[0];
  }
  function getCat(string $cat)
  {
    return $this->cats[$cat];
  }
}