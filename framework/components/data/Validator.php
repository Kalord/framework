<?php

namespace app\framework\components\data;

use Exception;
use app\framework\components\ErrorDataStorage;
use app\framework\core\ActiveRecord;

/**
 * Компонент для валидации данных
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data
 */
class Validator
{
    /**
     * @const string
     */
    const validatorPackage = 'app\framework\components\data\validators\\';

    /**
     * Валидация данных
     * 
     * Данный метод принимает следующую структуру данных:
     * ['PropertyName', 'ValidatorName', ['params', 'for', 'validator']]
     * 
     * Пример: 
     *      $data = [
     *          ['foo', 'string'],
     *          ['bar', 'string', ['length' => [3, 255]]],
     *          ['bazzz', 'int']
     *      ]
     * 
     * Данные об ошибках будут хранится в ErrorDataStorage
     * 
     * @param object $model
     * @param array $data
     * @param object $errorStorage
     * @return bool
     */
    public function validate(ActiveRecord $model, array $data, ErrorDataStorage $errorStorage)
    {
        foreach($data as $item)
        {
            $propertyName = array_shift($item);
            $dataForValidation = [];

            if(is_array($propertyName))
            {
                foreach($propertyName as $property) $dataForValidation[$property] = $model->$property;
            }
            else
            {
                $dataForValidation[$propertyName] = $model->$propertyName;
            }

            $validatorName = self::validatorPackage . ucfirst(array_shift($item)) . 'Validator';
            $args = array_shift($item);
            $validator = new $validatorName($args, $errorStorage);

            foreach($dataForValidation as $property => $value)
            {
                $validator->run($property, $value);
            }
        }

        return !$errorStorage->hasErrors();
    }
};