<?php

namespace app\framework\components;

/**
 * Класс для работы с куками
 *
 * @package app\framework\components
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class Cookie
{
    /**
     * @const int
     */
    const DAY = 60 * 60 * 24;

    /**
     * @const int
     */
    const WEEK = self::DAY * 7;

    /**
     * @const int
     */
    const MONTH = self::WEEK * 4;

    /**
     * @param mixed $key
     * @param mixed $value
     * @param int|float $expires
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return bool
     */
    public function set($key, $value, $expires = self::MONTH, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        return setcookie($key, $value, time() + $expires, $path, $domain, $secure, $httponly);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function remove($key)
    {
        if($this->get($key) != null) return $this->set($key, 0, -1);
        return false;
    }
}