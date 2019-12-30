<?php

namespace app\controllers;

use app\framework\core\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        var_dump('Home page');
    }

    public function actionLogin()
    {
        var_dump('Login');
    }

    public function actionRegistration()
    {
        var_dump('Registration');
    }
}