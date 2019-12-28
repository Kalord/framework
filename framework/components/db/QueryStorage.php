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
    public $innerJoin = null;

    /**
     * @var string|null
     */
    public $leftJoin = null;

    /**
     * @var string|null
     */
    public $rightJoin = null;

    /**
     * @var string|null
     */
    public $where = null;

    /**
     * @var string|null
     */
    public $orderBy = null;

    /**
     * @var string|null
     */
    public $limit = null;

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