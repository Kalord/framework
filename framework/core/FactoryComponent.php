<?php

namespace app\framework\core;

use Exception;

/**
 * Производитель компонентов
 * @package app\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class FactoryComponent
{
    /**
     * Конфигурация компонентов
     * @see configs/components.php
     * @var array
     */
    private $components;

    /**
     * Ключ в конфигурационном массиве, для получение пакета
     * @var string
     */
    const PACKAGE = 'package';

    /**
     * @param string $pathToConfig
     * @throws Exception
     */
    public function __construct($pathToConfig)
    {
        if(!file_exists($pathToConfig))
        {
            throw new Exception('File with config components not found in configs/components.php');
        }

        $this->components = require $pathToConfig;
    }

    /**
     * Метод __get() будет выполнен при чтении данных из несуществующих свойств.
     * @see https://www.php.net/manual/ru/language.oop5.overloading.php#object.get
     * @param string $alias
     * @return object|null
     */
    public function __get($alias)
    {
        return key_exists($alias, $this->components) ? new $this->components[$alias][self::PACKAGE]() : null;
    }
}