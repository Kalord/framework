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
     * @var mixed
     */
    protected $data;


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
    public function __construct($data, $args, ErrorDataStorage $errorStorage)
    {
        $this->data = $data;
        $this->args = $args;
        $this->errorStorage = $errorStorage;
    }

    /**
     * @return mixed
     */
    public function getDataForValidation()
    {
        return $this->data;
    }

    /**
     * @param string $propertyName
     * @param array $data
     */
    public function run($propertyName)
    {
        if(!$this->args) return;

        foreach($this->args as $methodName => $params)
        {
            $result = call_user_func_array([$this, $methodName], $params);
            if($result) $this->errorStorage->setError($propertyName, $result);
        }
    }
}