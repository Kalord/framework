<?php

namespace app\framework\helpers;

/**
 * Помощник для объектов
 * @package app\framework\helpers
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class ObjectHelper
{
    public static function className($object)
    {
        return get_class($object);
    }

    public static function classNameWithoutNamespace($className)
    {
        $matches = [];
        preg_match('~\w+$~', $className, $matches);
        return $matches[0];
    }

    /**
     * @param object $object
     * @return array
     */
    public static function iterationAtObject($object)
    {
        $data = [];
        foreach($object as $property => $value) $data[$property] = $value;
        return $data;
    }
}