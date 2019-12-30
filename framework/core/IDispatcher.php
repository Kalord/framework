<?php

namespace app\framework\core;

/**
 * Интерфейс для классов, который используют определенный набор диспетчеров,
 * который срабатывают каждый раз перед и/или после выполнения определенного метода
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
interface IDispatcher
{
    /**
     * @return void
     */
    public function dispatch();
}