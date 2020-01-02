<?php

namespace app\framework\components\user;

use Exception;
use app\framework\core\App;
use app\framework\components\Cookie;
use app\framework\components\user\Identity;

/**
 * Компонент для работы с пользователем
 *
 * @package app\framework\components\user
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class User
{
    /**
     * @const string
     */
    const COOKIE_KEY = 'data';

    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        /**
         * @start
         * TODO: Переделать реализацию
         * @see https://trello.com/c/J6ksQFzN/16-%D1%80%D0%B5%D0%B0%D0%BB%D0%B8%D0%B7%D0%BE%D0%B2%D0%B0%D1%82%D1%8C-%D0%BF%D0%B5%D1%80%D0%B5%D0%B4%D0%B0%D1%87%D1%83-%D0%B2-user-component-%D0%BC%D0%B0%D1%80%D1%88%D1%80%D1%83%D1%82%D0%B0-%D0%B4%D0%BE-%D0%BA%D0%BE%D0%BD%D1%84%D0%B8%D0%B3%D1%83%D1%80%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D0%BE%D0%B3%D0%BE-%D1%84%D0%B0%D0%B9%D0%BB%D0%B0
         */
        $this->config = require 'configs/components.php';
        /**
         * @end
         */
        $this->config = $this->config['user'];
    }

    /**
     * Авторизация пользователя
     *
     * @param \app\framework\components\user\Identity $model
     * @param float|int $expires
     * @return bool
     * @throws Exception
     */
    public function login(Identity $model, $expires = Cookie::MONTH)
    {
        return App::component()->cookie->set(self::COOKIE_KEY, $model->getAuthKey(), $expires);
    }

    /**
     * Деаутентификация пользователя
     *
     * @return bool
     * @throws Exception
     */
    public function logout()
    {
        if(App::component()->cookie->get(self::COOKIE_KEY) != null)
        {
            return App::component()->cookie->remove(self::COOKIE_KEY);
        }
        return false;
    }

    /**
     * Получение сущности пользователя
     *
     * @return mixed
     * @throws Exception
     */
    public function getIdentity()
    {
        $model = new $this->config['identity'];

        if($model instanceof Identity)
        {
            return $model->findByAuthKey(App::component()->cookie->get(self::COOKIE_KEY));
        }
        return null;
    }
}