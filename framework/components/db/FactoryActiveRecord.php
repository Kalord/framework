<?php

namespace app\framework\components\db;

use app\framework\helpers\ArrayHelper;

/**
 * Производитель ActiveRecord объектов
 * @package app\framework\components\db
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class FactoryActiveRecord
{
    /**
     * @param array $data
     * @param string $model
     * @return array|object
     */
    public static function factory(array $data, $model)
    {
        if(ArrayHelper::isMultidimensional($data))
        {
            $records = [];
            foreach($data as $record)
            {
                $activeRecord = new $model;
                $activeRecord->fetchData($record);
                $records[] = $activeRecord;
            }
            return $records;
        }
        $record = new $model;
        $record->fetchData($data);
        return $record;
    }
}