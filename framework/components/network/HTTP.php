<?php

namespace app\framework\components\network;

use app\framework\components\network\Request;

/**
 * Компонент для работы с HTTP протоколом
 * @package app\framework\components
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class HTTP
{
    /**
     * Работа с HTTP запросами
     * @return object
     */
    public function request()
    {
        return new Request();
    }
}