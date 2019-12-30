<?php

namespace app\framework\helpers;

/**
 * Помощник для работы с регулярными выражениями
 * @package app\framework\helpers
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class RegExpHelper
{
    /**
     * Преобразует строку в корректное регулярное выражения
     *
     * Правила преобразования:
     *      <string> - \D+
     *      <int> - \d+
     *
     * @param $string
     * @return string
     */
    public static function toRegExp($string)
    {
        $rules = ['~<string>~' => '\D+', '~<int>~' => '\d+'];

        foreach($rules as $rule => $regExp) $string = preg_replace($rule, "($regExp)", $string);

        return "~$string~";
    }
}