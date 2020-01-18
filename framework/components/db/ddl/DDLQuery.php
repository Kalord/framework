<?php

namespace app\framework\components\db\ddl;

use app\framework\components\db\DataBase;

/**
 * Компонент для работы с SQL запросами типа DDL
 * 
 * Data Definition Language (DDL) (язык описания данных) — это семейство компьютерных языков, 
 * используемых в компьютерных программах для описания структуры баз данных.
 * @see https://ru.wikipedia.org/wiki/Data_Definition_Language
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class DDLQuery
{
    /**
     * @var object
     */
    private $db;

    public function __construct()
    {
        $this->db = (new DataBase())->getConnect();
    }

    /**
     * Создание таблицы
     * 
     * Пример:
     *      php```
     *      $DDLQuery->createTable('user', [
     *          'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
     *          'login VARCHAR(30) NOT NULL',
     *          'password VARCHAR NOT NULL'
     *      ])
     *      ```
     *      После вызова данного метода будет создана следующая таблица:
     *      +++++++++++++++++++++++++
     *      + id + login + password +
     *      +++++++++++++++++++++++++
     * 
     * @param string $tableName
     * @param array $columns
     * @return bool
     */
    public function createTable($tableName, array $columns)
    {
        $columns = implode(', ', $columns);
        return $this->db->query("CREATE TABLE $tableName ($columns)");
    }

    /**
     * Удаление таблицы
     * 
     * @param string $tableName
     * @return void
     */
    public function dropTable($tableName)
    {
        return $this->db->query("DROP TABLE $tableName");
    }
}