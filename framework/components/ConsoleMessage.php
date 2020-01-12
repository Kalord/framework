<?php

namespace app\framework\components;

use Shasoft\Console\Console;

/**
 * Компонент для вывода сообщений в консоль
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class ConsoleMessage
{
    public function successMessage($message)
    {
        Console::color('green')->write($message)->enter();
    }

    public function errorMessage($message)
    {
        Console::color('red')->write($message)->enter();
    }
}