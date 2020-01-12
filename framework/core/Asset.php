<?php

namespace app\framework\core;

use app\framework\helpers\HtmlHelper;

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
     * Массив со всеми CSS ресурсами
     * @var array
     */
    public $css;

    /**
     * Массив со всеми JS ресурсами
     * @var array
     */
    public $js;

    /**
     * @const int
     */
    const CSS = 1;

    /**
     * @const int
     */
    const JS = 2;

    /**
     * Исключение определенных файлов
     * @const string
     */
    const NOT = 'not';

    /**
     * Получение HTML по определенному ресурсу и его типу
     *
     * Тип определен константами CSS/JS
     *
     * @param int $assetType
     * @param string $asset
     * @return string
     */
    private function getHtml($assetType, $asset)
    {
        if($assetType == self::CSS)
        {
            return HtmlHelper::create(
                'link',
                HtmlHelper::NOT_CLOSED,
                [
                    'rel' => 'stylesheet',
                    'href' => $asset
                ]
            );
        }

        return HtmlHelper::create(
            'script',
            HtmlHelper::CLOSED,
            [
                'src' => $asset
            ]
        );
    }

    /**
     * Получение всех ресурсов по определенному типу
     *
     * @param int $assetType
     * @param array $assetList
     * @return string
     */
    private function getAll($assetType, array $assetList)
    {
        $html = '';
        foreach ($assetList as $asset)
        {
            $html .= $this->getHtml($assetType, $asset);
        }
        return $html;
    }

    /**
     * Получение ресурсов за исключением определенных
     *
     * @param int $assetType
     * @param array $assetList
     * @param array $notList
     * @return string
     */
    private function getBesides($assetType, array $assetList, array $notList)
    {
        $html = '';
        foreach ($assetList as $asset)
        {
            if(!in_array($asset, $notList))
            {
                $html .= $this->getHtml($assetType, $asset);
            }
        }
        return $html;
    }

    /**
     * @param int $assetType
     * @param string $asset
     * @return string|null
     */
    private function getAsset($assetType, $asset)
    {
        return $this->getHtml($assetType, $asset);
    }

    /**
     * Получение CSS ресурсов
     *
     * @param array|string|null $options
     * @return string
     */
    public function getCss($options = null)
    {
        if(is_array($options) && key_exists(self::NOT, $options))
        {
            return $this->getBesides(self::CSS, $this->css, $options[self::NOT]);
        }
        if(is_string($options))
        {
            return $this->getAsset(self::CSS, $options);
        }
        return $this->getAll(self::CSS, $this->css);
    }

    /**
     * Получение JS ресурсов
     *
     * @param array|string|null $options
     * @return string
     */
    public function getJs($options = null)
    {
        if(is_array($options) && key_exists(self::NOT, $options))
        {
            return $this->getBesides(self::JS, $this->css, $options[self::NOT]);
        }
        if(is_string($options))
        {
            return $this->getAsset(self::JS, $options);
        }
        return $this->getAll(self::JS, $this->js);
    }
}