<?php

require_once dirname(__DIR__) . '/config/app.php';
require_once ROOT . '/vendor/autoload.php';

use TestFramework\Components\Kernel\FrontController;

$kernel = new FrontController();
$kernel->start();
