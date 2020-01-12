<?php

namespace app\framework\helpers;

class AppHelper
{
    public static function isConsoleApp()
    {
        return isset($_SERVER['argv']);
    }

    public static function getConsoleArgs()
    {
        return array_slice($_SERVER['argv'], 2);
    }
}