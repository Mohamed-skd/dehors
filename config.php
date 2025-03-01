<?php
// UTILS 
define("SRC", $_SERVER["DOCUMENT_ROOT"] . "/");
require_once SRC . "vendor/autoload.php";
require_once SRC . "utils/Base.php";
session_start();

// constants
// define("SITE", "https://mohsd-dehors.free.nf");
define("SITE", "http://localhost:8080/");
define("STORAGE", SRC . "utils/storage/");
define("CMPS", SRC . "components/");
define("ASSETS", SITE . "dist/");
// define("ASSETS", SITE . "assets/");
define("IMGS", SITE . "assets/imgs/");
define("DESC", "");

// funcs 
$servFn = new Func\ServerFn();
$fileFn = new Func\FileFn();
$dateFn = new Func\DateFn();
$strFn = new Func\StringFn();
$domFn = new Func\DomFn();
$envDatas = $fileFn->getEnv();

// APP 
$title = "Dehors !";
$prodCtrl = new Controller\Products(STORAGE . "products.json");