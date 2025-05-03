<?php

namespace Util;

use Error;
use Exception;
use PDO;

abstract class DB
{
  private static PDO $db;
  private static bool $isSet = false;

  protected static function setDB(
    string $dbname,
    ?string $host = "localhost",
    ?string $user = "root",
    ?string $pwd = null,
    string $engine = "mysql"
  ) {
    try {
      if (self::$isSet) throw new Exception("Already set");

      if ($host) {
        $dsn = "$engine:host=$host;dbname=$dbname";
        self::$db = new PDO($dsn, $user, $pwd);
      } else {
        $dsn = "$engine:$dbname";
        self::$db = new PDO($dsn);
      }
      self::$isSet = true;
      return true;
    } catch (Exception | Error $err) {
      return errorLog($err);
    }
  }

  protected static function getDB()
  {
    if (!self::$isSet) throw new Exception("DB unset");
    return self::$db;
  }

  protected function request(string $sqlQuery, array $values = [])
  {
    if (!self::$isSet) throw new Exception("DB unset");

    $results = self::$db->prepare($sqlQuery);
    $results->execute($values);
    return $results;
  }
}