<?php

namespace app\framework\components;

/**
 * Хранилище ошибок
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components
 */
class ErrorDataStorage
{
    /**
     * @var array
     */
    private $errors;

    public function setError($key, $value)
    {
        $this->errors[$key] = $value;
    }

    public function getError($key)
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : null;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function firstError()
    {
        return isset($this->errors[0]) ? $this->errors[0] : null;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }
}