<?php
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
//echo "</pre>";
////var_dump(ROOT . '/vendor/autoload.php');
////die;

require_once ROOT . '/vendor/autoload.php';

use TestFramework\Components\Kernel\FrontController;

$kernel = new FrontController();
$kernel->start();
