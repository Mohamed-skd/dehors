<?php

namespace Func;

class ServerFn
{
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
    $curl = curl_init($link);

    if (isset($opts)) {
      curl_setopt_array($curl, $opts);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, $return);
    $exec = curl_exec($curl);
    return $exec ? json_decode($exec, true) : null;
  }

  function goLocation(string $location = "/")
  {
    header("location:" . $location);
    exit;
  }
}