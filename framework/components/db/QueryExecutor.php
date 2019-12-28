<?php

namespace app\framework\components\db;

use app\framework\components\db\DataBase;
use PDO;
use Exception;

/**
 * Класс для выполнения запросов в базу данных
 * @package app\framework\components\db
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class QueryExecutor
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
        $this->db = (new DataBase($pathToConfig))->getConnect();
    }

    public function one($sql, $placeholders)
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all($sql, $placeholders)
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $placeholders)
    {
        return $this->db->prepare($sql)->execute();
    }
}