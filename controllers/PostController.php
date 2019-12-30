<?php

namespace app\controllers;

use app\framework\core\Controller;
use app\models\Post;

class PostController extends Controller
{
    public function actionIndex()
    {
        var_dump('Home page for post');
    }

    public function actionDetail($id)
    {
        $post = Post::get($id);

        return $this->render('detail', [
            'post' => $post
        ]);
    }
}