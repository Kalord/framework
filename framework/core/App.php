<?php

namespace app\framework\core;

use app\framework\core\FactoryComponent;
use Exception;

/**
 * Класс для работы с приложением
 * Данный класс реализует фасад для компонентов @see public static function component();
 * @package app\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class App
{
    /**
     * Фасад для компонентов
     * Пример:
     *      Чтобы получить доступ к компоненту http, необходимо сделать следующий конфигурационный файл configs/components.php:
     *          ```php
     *          return [
     *              'http' => [
     *                  'package' => 'app\\components\\HTTP'
     *              ]
     *          ]
     *          ```
     *      Теперь, чтобы получить доступ к компоненту, достаточно:
     *          ```php
     *          App::component()->http;
     *          ```
     * @param string $pathToConfig
     * @return object
     * @throws Exception
     */
    public static function component($pathToConfig = 'configs/components.php')
    {
        return new FactoryComponent($pathToConfig);
    }
}