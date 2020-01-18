<?php

namespace app\framework\components\data\validators;

use app\framework\components\ErrorDataStorage;

/**
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 * @package app\framework\components\data\validators
 */
abstract class BaseValidator
{
    /**
     * @var array
     */
    protected $args;

    /**
     * @var object
     */
    protected $errorStorage;

    /**
     * @param mixed $data
     * @param array|null $args
     * @param object $errorStorage
     */
    public function __construct($args, ErrorDataStorage $errorStorage)
    {
        $this->args = $args;
        $this->errorStorage = $errorStorage;
    }

    /**
     * @param string $propertyName
     * @param array $data
     */
    public function run($propertyName, $data)
    {
        if($result = $this->defaultValidator($data))
        {
            $this->errorStorage->setError($propertyName, $result);
            return;
        }

        foreach($this->args as $methodName => $params)
        {
            $params = array_merge([$data], $params);
            $result = call_user_func_array([$this, $methodName], $params);
            if($result) $this->errorStorage->setError($propertyName, $result);
        }
    }

    abstract public function defaultValidator($data);
}