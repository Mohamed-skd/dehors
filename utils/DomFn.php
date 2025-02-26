<?php

namespace Func;

class DomFn
{
  function create(string $tag, string $value, array $attributes = [], bool $open = true)
  {
    $attrs = "";
    foreach ($attributes as $k => &$a) {
      $attrs .= " $k=\"$a\"";
    }
    return $open ? "<$tag$attrs>$value</$tag>\n" : "</$tag$attrs>\n";
  }
}