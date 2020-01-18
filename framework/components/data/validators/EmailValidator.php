<?php

namespace app\framework\components\data\validators;

use app\framework\components\data\validators\BaseValidator;

/**
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data\validators
 */
class EmailValidator extends BaseValidator
{
    public function defaultValidator($data)
    {
        if(!filter_var($data, FILTER_VALIDATE_EMAIL)) return 'Некорректная почта';
    }
}