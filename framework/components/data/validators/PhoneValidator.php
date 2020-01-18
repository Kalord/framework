<?php

namespace app\framework\components\data\validators;

use app\framework\components\data\validators\BaseValidator;

/**
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data\validators
 */
class PhoneValidator extends BaseValidator
{
    public function defaultValidator($data)
    {
        if(!is_string($data)) return 'Телефон должен быть представлен строкой';
        if(!preg_match('~^(\+)?\d+~', $data)) return 'Некорректный формат';
    }
}