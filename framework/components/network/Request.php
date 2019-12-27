<?php

namespace app\framework\components\network;

/**
 * Компонент для работы с HTTP запросами
 * @package app\framework\components\network
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class Request
{
    /**
     * Получение данных из суперглобального массива $_GET
     * @param mixed $key
     * @return mixed
     */
    public function get($key = null)
    {
        if(is_null($key)) return $_GET;
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Получение данных из суперглобального массива $_POST
     * @param mixed $key
     * @return mixed
     */
    public function post($key = null)
    {
        if(is_null($key)) return $_POST;
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
}