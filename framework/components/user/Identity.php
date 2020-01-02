<?php

namespace app\framework\components\user;

/**
 * Интерфейс для авториизации / аутентификации пользователя
 * Данный интерфейс должна расширить модель, которая реализует логику работы с пользователем
 *
 * @package app\framework\components\user
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
interface Identity
{
    /**
     * Данный метод возвращает ключ аутентификации
     * @return string
     */
    public function getAuthKey();

    /**
     * Поиск пользователя по ключу аутентификации
     * @param string $authKey
     * @return mixed
     */
    public function findByAuthKey($authKey);
}