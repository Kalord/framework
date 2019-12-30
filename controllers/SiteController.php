<?php

namespace app\controllers;

class SiteController
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