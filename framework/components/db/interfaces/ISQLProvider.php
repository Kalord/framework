<?php

namespace app\framework\components\db\interfaces;

/**
 * Интерфейс для SQL провайдеров
 * 
 * Класс который реализует данные интерфейс, является
 * хранилищем SQL запросов
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