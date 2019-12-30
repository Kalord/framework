<?php

namespace app\framework\core;

use Exception;
use app\framework\core\App;
use app\framework\helpers\RegExpHelper;

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
 *          '/post/<int>' => 'post/detail'
 *      ];
 *
 *      URL: http://site.local/post/1
 *      Route: $PostController->actionDetail(1);
 *
 *      configs/routes.php:
 *      return [
 *          '/post/<string>/<int> => 'post/detail'
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
     * @var string
     */
    const HOME_ROUTE = 'site/index';

    /**
     * @var string
     */
    const DEFAULT_ACTION = 'index';

    /**
     * Массив маршрутов заданных в конфигурационном файле
     * @var array
     */
    private $routes;

    /**
     * Пространство имен для контроллеров
     * @var string
     */
    private $namespace;

    /**
     * Базовый контроллер
     * @var string
     */
    private $baseController;

    /**
     * @var string
     */
    private $dispatcherInterface;

    /**
     * Router constructor.
     * @param string $namespace
     * @param string $baseController
     * @param string $dispatcherInterface
     * @param string $config
     * @throws Exception
     */
    public function __construct($namespace, $baseController, $dispatcherInterface, $config = 'configs/routes.php')
    {
        if(!file_exists($config))
        {
            throw new Exception("File with routes not found in $config");
        }
        $this->routes = require $config;
        $this->namespace = $namespace;
        $this->baseController = $baseController;
        $this->dispatcherInterface = $dispatcherInterface;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param array $route
     * @return bool
     */
    private function hasAction(array $route)
    {
        return count($route) == 2;
    }

    /**
     * Проверяет, сделан ли запрос на домашнюю страницу
     * @param string $url
     * @return array|null
     */
    private function homePage($url)
    {
        if($url == '/' && array_key_exists('/', $this->routes)) return [$this->routes['/'], []];
        if($url == '/') return [self::HOME_ROUTE, []];
        return null;
    }

    /**
     * Ищет маршруты в конфигурационном файле
     * @param string $url
     * @return array|null
     */
    private function findRouteInConfig($url)
    {
        if(empty($this->routes)) return null;

        foreach($this->routes as $urlPattern => $route)
        {
            $urlPattern = RegExpHelper::toRegExp($urlPattern);
            $args = [];
            if(preg_match_all($urlPattern, $url, $args, PREG_SET_ORDER))
            {
                $args = array_shift($args);
                array_shift($args);
                return [$route, $args];
            }
        }

        return null;
    }

    /**
     * Встраивает маршрут
     * @param array $route
     * @throws Exception
     */
    private function inlineRoute($route)
    {
        $dataRoute = explode('/', array_shift($route));
        if(!$this->hasAction($dataRoute)) $dataRoute[] = self::DEFAULT_ACTION;
        $dataArgs = array_shift($route);

        $ControllerName = ucfirst(array_shift($dataRoute)) . 'Controller';
        $actionName = 'action' . ucfirst(array_shift($dataRoute));
        $ControllerName = $this->getNamespace() . $ControllerName;

        $ControllerName = new $ControllerName();

        if(get_parent_class($ControllerName) == $this->baseController)
        {
            $interfaces = class_implements($this->baseController);
            if(key_exists($this->dispatcherInterface, $interfaces)) $ControllerName->dispatch();
            call_user_func_array([$ControllerName, $actionName], $dataArgs);
            return;
        }
        throw new Exception("Controller don't have parent base controller $this->baseController");
    }

    /**
     * Запуск роутера
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $url = App::component()->http->getUrl();

        if(($route = $this->homePage($url)) || ($route = $this->findRouteInConfig($url)))
        {
            $this->inlineRoute($route);
            return;
        }

        $this->inlineRoute([substr($url, 1), []]);
    }
}