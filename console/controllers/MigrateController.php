<?php

namespace app\console\controllers;

use app\framework\core\Controller;

class MigrateController extends Controller
{
    public function actionCreate($migrateName)
    {
        var_dump($migrateName);
    }
}