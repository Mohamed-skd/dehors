<?php

namespace Util;

use Error;
use Exception;
use PDO;

abstract class DB
{
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
      if (isset(self::$db)) return;

      if ($host) {
        self::$dsn = "$engine:host=$host;dbname=$dbname";
        self::$db = new PDO(self::$dsn, $user, $pwd);
      } else {
        self::$dsn = "$engine:$dbname";
        self::$db = new PDO(self::$dsn);
      }
    } catch (Exception | Error $err) {
      return errorLog($err);
    }
  }

  protected static function getDB()
  {
    return self::$db;
  }

  protected function request(string $sqlQuery, array $values = [])
  {
    $results = self::$db->prepare($sqlQuery);
    $results->execute($values);
    return $results;
  }
}