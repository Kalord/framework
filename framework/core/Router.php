<?php

namespace app\framework\core;

use Exception;

/**
 * Роутер определяет контроллер и действие
 * Маршруты определяются, либо из конфигурационного файла @see configs/routes.php
 * Либо, исходя из URL
 *
 * Примеры:
 *      URL: http://site.local/post
 *      Route: $PostController->actionIndex();
 *
 *      URL: http://site.local/user/info
 *      Route: $UserController->actionInfo();
 *
 *      URL: http://site.local
 *      Route: $SiteController->actionIndex();
 *
 * Если, имеется следующий конфигурационный файл:
 *      configs/routes.php:
 *          return [
 *              '/settings' => 'user/settings'
 *          ];
 *
 *      URL: http://site.local/settings
 *      Route: $UserController->actionSettings()
 *
 * Передача аргументов в маршрут:
 *      configs/routes.php:
 *      return [
 *          '/post/<id:int>' => 'post/detail'
 *      ];
 *
 *      URL: http://site.local/post/1
 *      Route: $PostController->actionDetail(1);
 *
 *      configs/routes.php:
 *      return [
 *          '/post/<category:string>/<id:int> => 'post/detail'
 *      ];
 *
 *      URL: http://site.local/post/sport/1
 *      URL: $PostController->actionDetail('sport', 1);
 *
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class Router
{
    /**
     * Массив маршрутов заданных в конфигурационном файле
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     * @param string $config
     * @throws Exception
     */
    public function __construct($config = 'configs/routes.php')
    {
        if(!file_exists($config))
        {
            throw new Exception("File with routes not found in $config");
        }
        $this->routes = require $config;
    }

    /**
     * Запуск приложения
     * @return void
     */
    public function run()
    {

    }
}