<?php

namespace app\framework\components\db;

use Exception;
use app\framework\components\db\QueryStorage;
use app\framework\components\db\QueryExecutor;
use app\framework\components\db\FactoryActiveRecord;

/**
 * Компонент для построение запросов в базу данных
 * @package app\framework\components\db
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class QueryBuilder
{
    /**
     * Таблица для построения запросов
     * @var string
     */
    private $tableName;

    /**
     * Хранилище запросов в базу данных
     * @var object
     */
    private $queryStorage;

    /**
     * Объект для выполнения запросов
     * @var object
     */
    private $queryExecutor;

    /**
     * Триггер создания объектов ActiveRecord
     * @var bool
     */
    private $factoryActiveRecord;

    /**
     * Название модели, объект/объекты которой будут созданы
     * @var string
     */
    private $currentModel;

    /**
     * Заполнители
     * @var array
     */
    private $placeholders;

    /**
     * @param string $tableName
     * @param $currentModel
     * @param string $pathToConfig
     * @throws Exception
     */
    public function __construct($tableName, $currentModel, $pathToConfig = 'configs/db.php')
    {
        $this->tableName = $tableName;
        $this->queryStorage = new QueryStorage();
        $this->queryExecutor = new QueryExecutor($pathToConfig);
        $this->currentModel = $currentModel;
        $this->factoryActiveRecord = true;
        $this->placeholders = [];
    }

    /**
     * Добавление данных в массив с заполнителями
     * @param array|string $data
     */
    private function addPlaceholders($data)
    {
        if(is_array($data))
        {
            array_filter($data, function($item) {
                array_push($this->placeholders, $item);
            });
            return;
        }

        if(is_string($data))
        {
            $this->placeholders[] = $data;
            return;
        }
    }

    /**
     * @return array
     */
    public function getPlaceholders()
    {
        return $this->placeholders;
    }

    /**
     * @return string
     */
    public function getCurrentModel()
    {
        return $this->currentModel;
    }

    /**
     * @return bool
     */
    public function isFactoryActiveRecord()
    {
        return $this->factoryActiveRecord;
    }

    /**
     * @param array $condition
     * @return array
     */
    private function parseCondition($condition)
    {
        if(count($condition) == 3)
        {
            return [
                'operator' => array_shift($condition),
                'key'      => array_shift($condition),
                'value'    => array_shift($condition)
            ];
        }

        return [
            'operator' => '=',
            'key'   => array_key_first($condition),
            'value' => array_values($condition)[0]
        ];
    }

    /**
     * Примеры:
     *      sql```
     *      SELECT * FROM post;
     *      ```
     *      php```
     *      Post::query()->select();
     *      ```
     *
     *      sql```
     *      SELECT id FROM post;
     *      ```
     *      php```
     *      Post::query()->select(['id']);
     *      ```
     *
     *      sql```
     *      SELECT id, title, content FROM post;
     *      ```
     *      php```
     *      Post::query()->select(['id', 'title', 'content']);
     *      ```
     *
     * @param array $selection
     * @return object
     */
    public function select($selection = ['*'])
    {
        $selection = implode(', ', $selection);
        $this->queryStorage->select = "SELECT $selection FROM $this->tableName";
        return $this;
    }

    /**
     * Примеры:
     *      sql```
     *      WHERE id = 1;
     *      ```
     *      php```
     *      Post::query()->where(['id' => 1]);
     *      ```
     *
     *      sql```
     *      WHERE id > 10
     *      ```
     *      php```
     *      Post::query()->where(['>', 'id', 10]);
     *      ```
     *
     *      sql```
     *      WHERE id < 10
     *      ```
     *      php```
     *      Post::query()->where(['<', 'id', 10]);
     *      ```
     *
     *      sql```
     *      WHERE title != 'Data'
     *      ```
     *      php```
     *      Post::query()->where(['!=', 'title', 'Data']);
     *      ```
     * @param array $condition
     * @return object
     */
    public function where($condition)
    {
        $condition = $this->parseCondition($condition);

        $this->addPlaceholders([$condition['value']]);
        $operator = $condition['operator'];
        $key = $condition['key'];

        $this->queryStorage->where = "WHERE $key $operator ?";

        return $this;
    }

    /**
     * @return object
     */
    public function asArray()
    {
        $this->factoryActiveRecord = false;

        return $this;
    }

    /**
     * @return string
     */
    private function build()
    {
        return $this->queryStorage->getSql();
    }

    /**
     * Высокоуровневая абстракция для выполнения зарпосов
     * Данный метод реализуется посредством исполнителя запросов
     * После выполнения запроса, в случае успеха создает ActiveRecord модел,
     * Если иное неопределенно методов asArray().
     *
     * Примеры:
     *      php```
     *      Post::query()->select()->one();
     *      Post::query()->select()->where(['id' => 1])->one();
     *      Post::query()->select()->asArray()->one();
     *      ```
     * @return object|null
     */
    public function one()
    {
        $record = $this->queryExecutor->one($this->build(), $this->getPlaceholders());
        if(!$record) return null;

        return $this->isFactoryActiveRecord() ? FactoryActiveRecord::factory($record, $this->getCurrentModel()) : $record;
    }

    /**
     * Высокоуровневая абстракция для выполнения зарпосов
     * Данный метод реализуется посредством исполнителя запросов
     * После выполнения запроса, в случае успеха создает ActiveRecord модели,
     * Если иное неопределенно методов asArray().
     *
     * Примеры:
     *      php```
     *      Post::query()->select()->all();
     *      Post::query()->select()->where(['<', 'id', 10])->all();
     *      Post::query()->select()->innerJoin('user')->on(['post.id_user' => 'user.id'])->all();
     *      ```
     *
     * @return object|null
     */
    public function all()
    {
        $records = $this->queryExecutor->all($this->build(), $this->getPlaceholders());
        if(!$records) return null;

        return $this->isFactoryActiveRecord() ? FactoryActiveRecord::factory($records, $this->getCurrentModel()) : $records;
    }

    /**
     * Высокоуровневая абстракция для выполнения зарпосов
     * Данный метод реализуется посредством исполнителя запросов
     *
     * Пример:
     *      php```
     *      $post = new Post();
     *      $post->title = 'Hello';
     *      $post->content = 'Data';
     *      $post->save()
     *      ```
     *      В данном случае неявно будет вызван данный метод.
     * Пример явного вызова:
     *      php```
     *      Post::query()->delete()->execute();
     *      ```
     *
     * @return bool
     */
    public function execute()
    {
        return $this->queryExecutor->execute($this->build(), $this->getPlaceholders());
    }
}