<?php

namespace app\framework\helpers;

/**
 * Помощник для массивов
 * @package app\framework\helpers
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class ArrayHelper
{
    /**
     * @param array $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @see https://www.php.net/manual/ru/function.count.php
     * @param array $array
     * @return bool
     */
    public static function isMultidimensional(array $array)
    {
        return !!(count($array) - count($array, COUNT_RECURSIVE));
    }
}