<?php

require_once dirname(__DIR__) . '/config/app.php';
require_once ROOT . '/vendor/autoload.php';

use TestFramework\Components\Database\Migrations;

$migrationsPath = ROOT . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "migrations" .DIRECTORY_SEPARATOR;

$migrations = new Migrations();
$migrations->createTableMigrate();
$migrations->init($migrationsPath, $_SERVER['argv']);

