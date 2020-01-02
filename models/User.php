<?php

namespace app\models;

use Exception;
use app\framework\core\ActiveRecord;
use app\framework\components\user\Identity;

/**
 * @property int id
 * @property string login
 * @property string password
 * @property string auth_key
 * @package app\models
 */
class User extends ActiveRecord implements Identity
{
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Поиск пользователя по ключу аутентификации
     * @param mixed $authKey
     * @return object|null
     * @throws Exception
     */
    public function findByAuthKey($authKey)
    {
        return self::query()->select()->where(['auth_key' => $authKey])->one();
    }
}