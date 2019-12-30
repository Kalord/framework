<?php

namespace app\framework\core;

use Exception;

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
     * @throws Exception
     */
    private function getLayout()
    {
        if(!file_exists($this->layout)) throw new Exception("Layout in $this->layout not found");
        require $this->layout;
    }

    /**
     * @param string $path
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function prepareView($path, array $data)
    {
        $this->buffering();
        $this->getView($path);
        $content = $this->getBuffer();

        $this->buffering();
        $this->getLayout();
        return $this->getBuffer();
    }

    /**
     * @param string $view
     */
    public static function render($view)
    {
        echo $view;
    }
}