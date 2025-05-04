<?php

namespace Controller;

use Error;
use Exception;
use Lib\Json;

class Products
{
  public array $list;
  public array $cats = [];

  /**
   * Products
   * @param string $file Json file to construct the products list
   */
  function __construct(string $file)
  {
    try {
      $this->list = (new Json($file))->parsed;

      foreach ($this->list as &$prod) {
        $this->cats[$prod["cat"]][] = $prod;
      }
      shuffle($this->list);
    } catch (Exception | Error $err) {
      errorLog($err);
    }
  }

  /**
   * Get search result 
   * @param string $search Product to search
   */
  function getProduct(string $search)
  {
    return array_values(array_filter($this->list, function ($val) use ($search) {
      return str_contains(strtolower($val["name"]), strtolower($search));
    }));
  }
  /**
   * Get a category of products
   * @param string $cat The category
   */
  function getCat(string $cat)
  {
    return $this->cats[$cat] ?? [];
  }
}