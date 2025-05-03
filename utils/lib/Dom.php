<?php

namespace Lib;

class Dom
{
  function create(string $tag, string $content, array $attributes = [], bool $open = true)
  {
    $attrs = "";
    foreach ($attributes as $name => &$value) {
      $attrs .= " $name=\"$value\"";
    }
    return $open ? "\n<$tag$attrs>$content</$tag>\n" : "\n</$tag$attrs>\n";
  }
}