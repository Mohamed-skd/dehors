<?php

namespace Func;

use DateTime;
use DateTimeZone;

class DateFn
{
  function formatDate(
    string $date = "now",
    string $format = "d/m/Y",
    string $timezone = "Europe/Paris"
  ) {
    $zone = "Europe/Paris";
    $dateTime = new DateTime($date, new DateTimeZone($zone));
    if ($zone !== $timezone) $dateTime->setTimezone(new DateTimeZone($timezone));
    return $dateTime->format($format);
  }
}