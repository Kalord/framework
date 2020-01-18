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

    /**
     * Тип данных - строка переменной длины 
     * @const string
     */
    const TYPE_VARCHAR = 'VARCHAR';

    /**
     * Тип данных - текст
     * @const string
     */
    const TYPE_TEXT = 'TEXT';

    /**
     * Добавление колонки
     * 
     * @var string $column
     * @return void
     */
    private function addColumn($column)
    {
        $this->columns[] = $column;
    }

    /**
     * Обновление последний колонки
     * 
     * @var string $sql
     * @return void
     */
    private function updateLastColumn($sql)
    {
        $this->columns[count($this->columns) - 1] .= $sql;
    }

    /**
     * @return array
     */
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
        $this->addColumn("$type NOT NULL PRIMARY KEY AUTO_INCREMENT ");
    }

    /**
     * Создание колонки с типом целого числа
     * 
     * @param int $length
     * @return void
     */
    public function createInteger($length)
    {
        $this->addColumn(self::TYPE_INT . "($length) ");
    }

    /**
     * Создание колонки типа varchar
     * 
     * @param int $length
     * @return void
     */
    public function createVarchar($length)
    {
        $this->addColumn(self::TYPE_VARCHAR . "($length) ");
    }

    /**
     * Созданик колонки типа text
     * 
     * @param int $length
     * @return void
     */
    public function createText($length)
    {
        $this->addColumn(self::TYPE_TEXT . "($length) ");
    }

    /**
     * @return void
     */
    public function createCurrentTimestamp()
    {
        $this->addColumn("DATETIME DEFAULT CURRENT_TIMESTAMP ");
    }

    /**
     * Добавление к последней колонки опции NOT NULL
     */
    public function notNull()
    {
        $this->updateLastColumn('NOT NULL ');
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function defaultValue($value)
    {
        $this->updateLastColumn("DEFAULT $value ");
    }
}