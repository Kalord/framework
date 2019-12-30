<?php

namespace app\controllers;

class PostController
{
    public function actionIndex()
    {
        var_dump('Home page for post');
    }

    public function actionDetail($category, $id)
    {
        var_dump("Current category: $category");
        var_dump("Id: $id");
    }
}