<?php

namespace Func;

use CurlHandle;

class ServerFn
{
  public ?CurlHandle $curl = null;

  function resJson(mixed $value)
  {
    header("content-type:application/json");
    echo json_encode($value);
    exit;
  }

  function sendEvent(?string $data = null, string $event = "open")
  {
    $id = uniqid();
    $data = json_encode($data);
    echo "id: $id\nevent: $event\ndata: $data\n\n";
  }

  function fetch(string $link, bool $return = true, ?array $opts = null)
  {
    $this->curl = curl_init($link);

    if (isset($opts)) {
      curl_setopt_array($this->curl, $opts);
    }

    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $return);
    $exec = curl_exec($this->curl);
    return $exec ? json_decode($exec, true) : null;
  }

  function goLocation(string $location = "/")
  {
    header("location:" . $location);
    exit;
  }
}