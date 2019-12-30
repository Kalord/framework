<?php

namespace app\framework\core;

use Exception;
use app\framework\core\IDispatcher;
use app\framework\core\App;

/**
 * Базовый класс для контроллеров
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
abstract class Controller implements IDispatcher
{
    /**
     * Данный метод получает набор классов диспетчеров и выполняет их каждый раз при запуске действия
     *
     * Пример:
     *      php```
     *      public function userDispatch()
     *      {
     *          return [
     *              'app\core\dispatcher\User' => [
     *                  'actions' => ['login', 'registration', 'profile', 'logout'],
     *                  'rules' => [
     *                      'canGuest' => [
     *                          'login', 'registration'
     *                      ],
     *                      'canUser' => [
     *                          'profiler', 'logout'
     *                      ]
     *                  ]
     *              ]
     *          ]
     *      }
     *      ```
     *
     * @inheritDoc
     * @return void
     */
    public function dispatch()
    {
        var_dump('In dispatch');
    }

    /**
     * @param string $url
     * @param void
     * @throws Exception
     */
    protected function redirect($url)
    {
        App::component()->http->redirect($url);
    }

    /**
     * @return void;
     * @throws Exception
     */
    protected function goHome()
    {
        $this->redirect('/');
    }
}