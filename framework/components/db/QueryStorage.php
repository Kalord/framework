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
    public $insert = null;

    /**
     * @var string|null
     */
    public $update = null;

    /**
     * @var string|null
     */
    public $delete = null;

    /**
     * @var string|null
     */
    public $set = null;

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
     * @var array
     */
    public $on = [];

    /**
     * @var array
     */
    public $where = [];

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
            if(is_string($subCommand))
            {
                $sql .= "$subCommand ";
                continue;
            }
            if(is_array($subCommand))
            {
                foreach ($subCommand as $exp) $sql .= "$exp ";
            }
        }
        return $sql;
    }
}