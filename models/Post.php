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
    public static function pathToConfig()
    {
        return '../configs/db-test.php';
    }

    public function getId()
    {
        return $this->id;
    }
}