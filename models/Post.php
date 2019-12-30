<?php

namespace app\models;

use app\framework\core\ActiveRecord;

/**
 * @property int $id;
 * @property string $title
 * @property string $content
 * @package app\models
 */
class Post extends ActiveRecord
{
    public static function get($id)
    {
        return self::query()->select()->where(['id' => $id])->one();
    }
}