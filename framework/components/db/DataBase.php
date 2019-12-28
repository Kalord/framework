<?php

namespace app\framework\components\db;

use PDO;
use Exception;

/**
 * Компонент для работы с базой данных
 * Конфигурационный файл базы данных @see configs/db.php
 * @package app\framework\components\db
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class DataBase
{
    /**
     * @var object
     */
    private $db;

    /**
     * @param string $pathToConfig
     * @throws Exception
     */
    public function __construct($pathToConfig = 'configs/db.php')
    {
        if(!file_exists($pathToConfig))
        {
            throw new Exception("Config for connection to database not found in $pathToConfig");
        }

        $config = require $pathToConfig;
        $this->db = new PDO($config['dsn'], $config['user'], $config['password']);
    }

    public function getConnect()
    {
        return $this->db;
    }
}