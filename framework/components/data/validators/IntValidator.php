<?php

namespace app\framework\components\data\validators;

use app\framework\components\data\validators\BaseValidator;

/**
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data\validators
 */
class IntValidator extends BaseValidator
{
    public function defaultValidator($data)
    {
        if(!is_int($data)) return 'Данные не являются числом';
    }
}