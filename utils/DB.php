<?php

namespace Util;

use Error;
use Exception;
use PDO;

abstract class DB
{
  private static bool $isSet = false;
  private static string $dsn;
  private static PDO $db;

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
        self::$dsn = "$engine:host=$host;dbname=$dbname";
        self::$db = new PDO(self::$dsn, $user, $pwd);
      } else {
        self::$dsn = "$engine:$dbname";
        self::$db = new PDO(self::$dsn);
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