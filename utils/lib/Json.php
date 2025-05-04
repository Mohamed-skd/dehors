<?php

namespace Lib;

use Exception;

class Json
{
  private Dom $domFn;
  private bool $canProceed = false;
  public string $content;
  public array $parsed;

  function __construct(public string $file)
  {
    if (!file_exists($this->file)) throw new Exception("No file: {$this->file}");
    if (pathinfo($this->file, PATHINFO_EXTENSION) !== "json") throw new Exception("Invalid json: {$this->file}");

    $this->domFn = new Dom();
    $this->content = file_get_contents($this->file);
    if (!$this->content) throw new Exception("Error while getting file content");

    $this->parsed = json_decode($this->content, true);
    if (!$this->parsed) throw new Exception("Error while parsing json");
    $this->canProceed = true;
  }

  function toHtml(string $type = "table", bool $outfile = false)
  {
    if (!$this->canProceed) return $this;
    if (!$this->isObjectsArray()) throw new Exception("Invalid format");

    $types = [
      "table" => $this->toHtmlTable(),
      "list" => $this->toHtmlList($this->parsed, true),
    ];
    if (!isset($types[$type])) throw new Exception("Invalid type: $type");

    $htmlName = basename($this->file, ".json");
    $htmlContent = $types[$type];
    $style = "
:root {
font-family: system-ui;
box-sizing: border-box;
}

body {
background: fixed
linear-gradient(
135deg,
hsl(120, 60%, 60%, 0.6),
hsl(120, 60%, 60%, 0.4),
hsl(120, 60%, 60%, 0.6)
);
}

h1 {
padding: 1.6rem;
font-size: 2.4rem;
text-transform: uppercase;
text-align: center;
}

main > div {
margin: 1rem auto;
width: min(100% - 1rem, 80rem);
}

.table {
border-collapse: collapse;

td {
padding: 0.6rem;
text-align: center;
font-size: 1.2rem;
border: 2px solid;
}
}

.list {
& > li {
margin-bottom: 0.4rem;
padding: 0.6rem;
display: block;
border: 2px solid;
}

li {
font-size: 1.2rem;
}
}";
    $html = "
<!DOCTYPE html>
<html>
<head>
<meta charset=\"UTF-8\" />
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
<style>
$style
</style>
<title>$htmlName</title>
</head>

<body>
<header>
<h1>$htmlName</h1>
</header>

<main>
<div style=\"overflow-x:scroll\">
$htmlContent
</div>
</main>
</body>
</html>
      ";

    if ($outfile) {
      file_put_contents("$htmlName.html", $html);
    } else {
      return $html;
    }
  }

  function isObjectsArray()
  {
    if (!$this->canProceed) return $this;
    if ($this->areArrays()) return $this->areSameFields();
    return false;
  }

  function areArrays()
  {
    if (!$this->canProceed) return $this;
    return array_all($this->parsed, function ($obj) {
      return is_array($obj);
    });
  }

  function areSameFields()
  {
    if (!$this->canProceed) return $this;
    $baseKeys = array_keys($this->parsed[0]);

    return array_all($this->parsed, function ($obj) use ($baseKeys) {
      $keys = array_keys($obj);
      return (!array_diff($baseKeys, $keys) && !array_diff($keys, $baseKeys));
    });
  }

  protected function toHtmlTable()
  {
    $tag = $this->domFn;
    $bodyContent = implode("", array_map(function ($tr) use ($tag) {
      return $tag->create("tr", implode("", array_map(function ($d) use ($tag) {
        $d = is_array($d) ? $this->toHtmlList($d) : $d;
        return $tag->create("td", $d);
      }, $tr)));
    }, $this->parsed));

    return $tag->create(
      "table",
      $tag->create("tbody", $bodyContent),
      ["class" => "table"]
    );
  }

  protected function toHtmlList(array $obj, bool $isFirst = false)
  {
    $tag = $this->domFn;

    return $tag->create("ul", implode("", array_map(function ($val) use ($tag) {
      $val = is_array($val) ? $this->toHtmlList($val, false) : $val;
      return $tag->create("li", $val);
    }, $obj)), ($isFirst ? ["class" => "list"] : []));
  }
}