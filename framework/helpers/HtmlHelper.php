<?php

namespace app\framework\helpers;

/**
 * Помощник для работы с HTML
 * @package app\framework\helpers
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class HtmlHelper
{
    public static function createLink($rel, $href)
    {
        return "<link rel=\"$rel\" href=\"$href\"";
    }
}