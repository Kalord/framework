<?php

namespace app\framework\core;

/**
 * Класс для работы с ресурсами сайта
 *
 * Пример:
 *      Определим класс с базовым набором ресурсов assets/AssetBase.php:
 *      php```
 *      class AssetBase extends Asset
 *      {
 *          public $css = [
 *              'css/bootstrap.css',
 *              'css/main.css',
 *              'css/media.css'
 *          ]
 *          public $js = [
 *              'js/jquery.js',
 *              'js/main.js'
 *          ]
 *      }
 *      ```
 *      views/layout/main.php:
 *      php```
 *      $asset = new AssetBase();
 *
 *      $asset->getCss(); //Получение всех CSS файлов
 *      $asset->getJs();  //Получение всех JS файлов
 *
 *      $asset->getCss('css/main.css'); //Получение main.css
 *      $asset->getJs('js/main.js'); //Получение main.js
 *
 *      $asset->getCss(['not' => ['css/main.css']); //Получение всех CSS файлов, кроме main.css
 *      ```
 *
 * @package app\framework\core
 * <artem.tyutnev.developer@gmail.com>
 */
class Asset
{
    /**
     * @var array
     */
    public $css;

    /**
     * @var array
     */
    public $js;

    /**
     * @param array|string|null $options
     */
    public function getCss($options = null)
    {
        if(is_array($options) && key_exists('not', $options))
        {
            
        }
    }
}