<?php

namespace app\framework\helpers;

/**
 * Помощник для работы с файлами
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class FileHelper
{
    public static function createFile($fileName)
    {
        return fopen($fileName, 'w');
    }

    public static function directoryExists($dirname)
    {
        return file_exists($dirname);
    }

    public static function createDirectory($dirname)
    {
        return mkdir($dirname);
    }

    public static function getFilesInDirectory($dirname)
    {
        return scandir($dirname);
    }
}