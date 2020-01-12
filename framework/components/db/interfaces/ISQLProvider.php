<?php

namespace app\framework\components\db\interfaces;

/**
 * Интерфейс для SQL провайдеров
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
interface ISQLProvider
{
    /**
     * @return string
     */
    public function getSql();
}