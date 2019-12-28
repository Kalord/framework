<?php

namespace app\framework\components\db;

/**
 * Хранилище запросов в базу данных
 * @package app\framework\components\db
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class QueryStorage
{
    /**
     * @var string|null
     */
    public $select = null;

    /**
     * @var string|null
     */
    public $where = null;

    /**
     * @return string
     */
    public function getSql()
    {
        $sql = '';
        foreach ($this as $subCommand)
        {
            if($subCommand != null)
            {
                $sql .= "$subCommand ";
                continue;
            }
        }
        return $sql;
    }
}