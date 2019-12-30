<?php

namespace app\controllers;

use app\models\Post;

class PostController
{
    public function actionIndex()
    {
        var_dump('Home page for post');
    }

    public function actionDetail($id)
    {
        $post = Post::get($id);
        var_dump($post);
    }
}