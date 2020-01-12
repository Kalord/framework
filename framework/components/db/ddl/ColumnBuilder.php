<?php

namespace app\framework\components\db\ddl;

/**
 * Построитель колонок для DDL запроса
 * 
 * Data Definition Language (DDL) (язык описания данных) — это семейство компьютерных языков, 
 * используемых в компьютерных программах для описания структуры баз данных.
 * @see https://ru.wikipedia.org/wiki/Data_Definition_Language
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class ColumnBuilder
{
    /**
     * Массив колонок
     * @var array
     */
    private $columns;

    /**
     * Тип данных - целое число
     * @const string
     */
    const TYPE_INT = 'INT';


    private function addColumn($column)
    {
        $this->columns[] = $column;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Создание колонки первичного ключа
     * 
     * @param string $type
     * @return void
     */
    public function createPrimaryKey($type = self::TYPE_INT)
    {
        $this->addColumn("$type NOT NULL PRIMARY KEY AUTO_INCREMENT");
    }
}