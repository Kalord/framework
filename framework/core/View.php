<?php

namespace app\framework\core;

use Exception;
use app\framework\core\RenderProvider;
use app\framework\helpers\ObjectHelper;

/**
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.at@gmail.com>
 */
class View
{
    /**
     * @var string
     */
    private $directoryWithViews;

    /**
     * @var string
     */
    private $layout;

    /**
     * @param $directoryWithViews
     * @param $layout
     */
    public function __construct($directoryWithViews, $layout)
    {
        $this->directoryWithViews = $directoryWithViews;
        $this->layout = $layout;
    }

    /**
     * Запуск буферизации данных
     * Если буферизация вывода активна, никакой вывод скрипта не отправляется,
     * а сохраняется во внутреннем буфере.
     * @see https://www.php.net/manual/ru/function.ob-start.php
     *
     * @return void
     */
    private function buffering()
    {
        ob_start();
    }


    /**
     * Получает содержимое текущего буфера и затем удаляет текущий буфер.
     * @see https://www.php.net/manual/ru/function.ob-get-clean.php
     *
     * @return string|false
     */
    private function getBuffer()
    {
        return ob_get_clean();
    }

    /**
     * Получение вида
     *
     * @param string $path
     * @param array $data
     * @return void
     * @throws Exception
     */
    private function getView($path, array $data)
    {
        if(!file_exists($path)) throw new Exception("View in $path not found");
        extract($data);

        require $path;
    }

    /**
     * Получение шаблона
     *
     * @return void
     * @param string
     * @throws Exception
     */
    private function getLayout($content)
    {
        if(!file_exists($this->layout)) throw new Exception("Layout in $this->layout not found");
        require $this->layout;
    }

    /**
     * Данный метод подготавливает путь до вида
     *
     * @param string $nameView
     * @param string $directory
     * @return string
     */
    private function preparePathToView($nameView, $directory)
    {
        $directory = ObjectHelper::classNameWithoutNamespace($directory);
        $directory = mb_strtolower(preg_replace('~Controller$~', '', $directory));
        $sep = DIRECTORY_SEPARATOR;

        return $this->directoryWithViews . $sep . $directory . $sep . $nameView . '.php';
    }

    /**
     * Данный метод подготавливает вид
     *
     * @param string $nameView
     * @param string $directory
     * @param array $data
     * @return object
     * @throws Exception
     */
    public function prepareView($nameView, $directory, array $data)
    {
        $this->buffering();
        $this->getView($this->preparePathToView($nameView, $directory), $data);
        $content = $this->getBuffer();

        $this->buffering();
        $this->getLayout($content);
        $view = $this->getBuffer();

        return new RenderProvider($view, $content);
    }

    /**
     * Данный метод отображает вид
     *
     * @param \app\framework\core\RenderProvider $renderProvider
     * @return void
     */
    public static function render(RenderProvider $renderProvider)
    {
        $content = $renderProvider->content;
        echo $renderProvider->view;
    }
}