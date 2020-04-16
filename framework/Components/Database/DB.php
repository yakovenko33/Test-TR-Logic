<?php

namespace TestFramework\Components\Database;


use \PDO;
use \PDOException;

class DB
{
    /**
     * @var DB
     */
    private static $instance;

    /**
     * @var \PDO
     */
    private static $connecting;

    /**
     * @return DB
     */
    static function getInstance(): DB
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
            static::$connecting = static::$instance->setConnecting();
        }

        return new static();
    }

    /**
     * @return PDO
     */
    public function getConnecting(): PDO
    {
        return static::$connecting;
    }

    /**
     * @return \PDO
     */
    private function setConnecting(): PDO
    {
        $configDB = require_once (ROOT . '/config/database.php');

        $dsn = "mysql:host={$configDB['host']};dbname={$configDB['db']};charset={$configDB['charset']}";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $configDB['user'], !empty($configDB['pass']) ? $configDB['pass'] : ""  , $opt);
    }

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}
}