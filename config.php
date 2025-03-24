<?php
// UTILS 
define("SRC", $_SERVER["DOCUMENT_ROOT"] . "/");
require_once SRC . "vendor/autoload.php";
require_once SRC . "utils/base.php";
session_start();

// constants
// define("SITE", "https://mohsd-dehors.free.nf/");
define("SITE", "http://localhost:8080/");
define("STORAGE", SRC . "utils/storage/");
define("CMPS", SRC . "components/");
// define("ASSETS", SITE . "dist/");
define("ASSETS", SITE . "assets/");
define("IMGS", SITE . "assets/imgs/");
define("DESC", "");

// funcs 
$dateFn = new Func\DateFn();
$fileFn = new Func\FileFn();
$strFn = new Func\StringFn();

// APP 
$title = "Dehors !";
$prodCtrl = new Controller\Products(STORAGE . "products.json");