<?php

namespace app\framework\components\data\validators;

use app\framework\components\data\validators\BaseValidator;

/**
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data\validators
 */
class StringValidator extends BaseValidator
{
    public function defaultValidator()
    {
        if(!is_string($this->getDataForValidation())) return 'Данные не являются строкой';
    }

    public function length($min, $max)
    {
        $data = $this->getDataForValidation();
        if(strlen($data) < $min) return "Строка должна быть больше, чем $min";
        if(strlen($data) > $max) return "Строка должна быть меньше, чем $max";
    }
}