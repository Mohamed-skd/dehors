<?php

namespace Func;

class StringFn
{
  function escape(string $string)
  {
    return trim(htmlspecialchars($string));
  }

  function sanitize(string $input, int $size = 100)
  {
    $input = $this->escape($input);
    if (!$input || strlen($input) > $size) return null;
    return $input;
  }
}