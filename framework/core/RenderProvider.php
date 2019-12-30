<?php

namespace app\framework\core;

/**
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class RenderProvider
{
    /**
     * @var string|null
     */
    public $view = null;

    /**
     * @var string|null
     */
    public $content = null;

    /**
     * RenderProvider constructor.
     * @param string|null $view
     * @param string|null $content
     */
    public function __construct($view, $content)
    {
        $this->view = $view;
        $this->content = $content;
    }
}