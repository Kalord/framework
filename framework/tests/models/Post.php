<?php

namespace app\framework\tests\models;

use app\framework\core\ActiveRecord;

/**
 * @property int $id;
 * @property string $title
 * @property string $content
 * @package app\models
 */
class Post extends ActiveRecord
{
    public function getId()
    {
        return $this->id;
    }
}