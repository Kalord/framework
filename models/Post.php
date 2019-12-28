<?php

namespace app\models;

use app\framework\core\ActiveRecord;

class Post extends ActiveRecord
{
    public function getId()
    {
        return $this->id;
    }
}