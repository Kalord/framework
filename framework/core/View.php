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
     * @return void
     */
    private function buffering()
    {
        ob_start();
    }


    /**
     * @return string|false
     */
    private function getBuffer()
    {
        return ob_get_clean();
    }

    /**
     * @param string $path
     * @return void
     * @throws Exception
     */
    private function getView($path)
    {
        if(!file_exists($path)) throw new Exception("View in $path not found");
        require $path;
    }

    /**
     * return void
     * @param string
     * @throws Exception
     */
    private function getLayout($content)
    {
        if(!file_exists($this->layout)) throw new Exception("Layout in $this->layout not found");
        require $this->layout;
    }

    private function preparePathToView($path, $directory)
    {
        $directory = ObjectHelper::classNameWithoutNamespace($directory);
        $directory = mb_strtolower(preg_replace('~Controller$~', '', $directory));
        $sep = DIRECTORY_SEPARATOR;

        return $this->directoryWithViews . $sep . $directory . $sep . $path . '.php';
    }

    /**
     * @param string $path
     * @param string $directory
     * @param array $data
     * @return object
     * @throws Exception
     */
    public function prepareView($path, $directory, array $data)
    {
        $this->buffering();
        $this->getView($this->preparePathToView($path, $directory));
        $content = $this->getBuffer();

        $this->buffering();
        $this->getLayout($content);
        $view = $this->getBuffer();

        return new RenderProvider($view, $content);
    }

    /**
     * @param \app\framework\core\RenderProvider $renderProvider
     * @return void
     */
    public static function render(RenderProvider $renderProvider)
    {
        $content = $renderProvider->content;
        echo $renderProvider->view;
    }
}