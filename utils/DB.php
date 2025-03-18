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
    ?string $host = null,
    ?string $user = null,
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
      return error($err);
    }
  }

  protected function req(string $query, array $args = [])
  {
    $results = self::$db->prepare($query);
    $results->execute($args);
    return $results;
  }

  protected function createTable(string $table, array $cols)
  {
    $colsStr = "";
    foreach ($cols as $col => &$spec) {
      $colsStr .= "$col $spec, ";
    }
    $colsStr = substr($colsStr, 0, -2);
    return $this->req("CREATE TABLE IF NOT EXISTS $table ($colsStr)");
  }

  protected function selectQuery(string $table, array $cols)
  {
    $query = "SELECT ";
    foreach ($cols as &$col) {
      $query .= "$col, ";
    }
    $query = substr($query, 0, -2);
    $query .= " FROM $table";
    return $query;
  }

  protected function insertQuery(string $table, array $content)
  {
    $queryCol = "(";
    $qData = "";
    $queryDatas = "VALUES ";
    $args = [];
    $argsCount = implode(",", array_map(fn() => "?", $content));
    $numArr = array_values($content);

    foreach ($content as $colname => &$_) {
      $queryCol .= "$colname,";
    }
    foreach ($numArr[0] as &$_) {
      $qData .= "($argsCount), ";
    }
    for ($i = $j = 0; $i <= count($numArr); $i++) {
      if ($i === count($numArr)) {
        $i = 0;
        $j++;
      }
      if ($j === count($numArr[$i])) break;
      $args[] = $numArr[$i][$j];
    }

    $queryDatas .= $qData;
    $queryCol = substr($queryCol, 0, -1);
    $queryDatas = substr($queryDatas, 0, -2);
    $query = "INSERT INTO $table $queryCol) $queryDatas";
    return [$query, $args];
  }

  protected function updateQuery(string $table, array $content)
  {
    $queryCol = "";
    $args = [];

    foreach ($content as $colname => &$data) {
      $queryCol .= "$colname=?, ";
      $args[] = $data;
    }

    $queryCol = substr($queryCol, 0, -2);
    $query = "UPDATE $table SET $queryCol";
    return [$query, $args];
  }

  protected function insertTable(string $table, array $content)
  {
    [$query, $args] = $this->insertQuery($table, $content);
    return $this->req($query, $args);
  }

  protected function updateTable(string $table, array $content)
  {
    [$query, $args] = $this->updateQuery($table, $content);
    return $this->req($query, $args);
  }

  protected function deleteTable(string $table)
  {
    return $this->req("TRUNCATE TABLE $table");
  }
}