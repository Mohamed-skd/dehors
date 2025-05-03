<?php
// UTILS 
define("SRC", $_SERVER["DOCUMENT_ROOT"] . "/");
require_once SRC . "vendor/autoload.php";
require_once SRC . "utils/base.php";
session_start();

// const SITE = "https://mohsd-dehors.free.nf/";
const SITE = "http://localhost:8080/";
const STORAGE = SRC . "utils/storage/";
const CMPS = SRC . "components/";
// const ASSETS = SITE . "dist/";
const ASSETS = SITE . "assets/";
const IMGS = SITE . "assets/imgs/";
const DESC = "";

$strFn = new Func\StringFn();

// APP 
$title = "Dehors !";
$prodCtrl = new Controller\Products(STORAGE . "products.json");