<?php

namespace app\framework\core;

use Exception;
use app\framework\components\db\QueryBuilder;
use app\framework\helpers\ObjectHelper;
use app\framework\components\ErrorDataStorage;
use app\framework\components\data\Validator;

/**
 * ActiveRecord - паттерн проектирования, предоставляющий объектно-ориентированную модель для доступа к данным
 * Пример:
 *      Допустим, есть следующая таблица post:
 *      ++++++++++++++++++++++++
 *      + id + title + content +
 *      ++++++++++++++++++++++++
 *      + 1  + Hello + Foo     +
 *      ++++++++++++++++++++++++
 *      + 2  + Test  + Bar     +
 *      ++++++++++++++++++++++++
 *      + 3  + Test  + Test    +
 *      ++++++++++++++++++++++++
 * Тогда, чтобы получить к ней доступ, необходимо создать модель Post
 *      php```
 *      class Post extends ActiveRecord
 *      {
 *          public static function tableName()
 *          {
 *              return 'post';
 *          }
 *      }
 *      ```
 * Существует четыре способа работы с данными:
 *      Create
 *      Read
 *      Update
 *      Delete
 *      php```
 *      //Create
 *      $post = new Post();
 *      $post->title = 'New';
 *      $post->content = 'Data';
 *      $post->save();
 *
 *      //Read
 *      $post = Post::query()->select()->where(['id' => 1])->one();
 *      $posts = Post::query()->select()->all();
 *      $posts = Post::query()->select()->where(['<', 'id', 10])->orderBy(['id' => SORT_DESC])->limit(10)->all();
 *
 *      //Update
 *      $post = Post::query()->select()->where(['id' => 1])->one();
 *      $post->content = 'Data';
 *      $post->save();
 *
 *      //Delete
 *      Post::query()->delete();
 *      Post::query()->delete()->where(['id' => 1])->execute();
 *      Post::query()->delete()->where(['<', 'id', 10])->execute();
 *      ```
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
abstract class ActiveRecord
{
    /**
     * @var bool
     */
    private $newRecord = true;

    /**
     * Первоначальный слепок данных
     * @var array
     */
    private $dataCast = [];

    /**
     * Хранилище ошибок валидации
     * @var object
     */
    private $errorStorage;

    /**
     * @param string $pathToConfig
     * @return object
     * @throws Exception
     */
    public static function query($pathToConfig = 'configs/db.php')
    {
        return new QueryBuilder(self::tableName(), get_called_class(), $pathToConfig);
    }

    private function isNewRecord()
    {
        return $this->newRecord;
    }

    public function getDataCast()
    {
        $data = $this->dataCast;
        $modified = $this->getModifiedData();

        foreach($modified as $property => $value) $data[$property] = $value;

        return $data;
    }

    /**
     * Сохранение данных в слепок данных
     * @param string $key
     * @param string $value
     */
    public function addDataCast($key, $value)
    {
        $this->dataCast[$key] = $value;
    }

    /**
     * @see https://www.php.net/manual/ru/language.oop5.overloading.php#object.set
     * Данный метод будет выполнен при записи данных в несуществующие свойства.
     * @param mixed $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->addDataCast($property, $value);
        $this->$property = $value;
    }

    /**
     * Преобразование данных из массива в публичные свойства
     * @param array $data
     */
    public function fetchData(array $data)
    {
        foreach($data as $property => $value)
        {
            $this->$property = $value;
            $this->addDataCast($property, $value);
        }

        $this->newRecord = false;
    }

    /**
     * @return array
     */
    private function getModifiedData()
    {
        $modifiedData = [];
        foreach(ObjectHelper::iterationAtObject($this) as $property => $value)
        {
            if(array_key_exists($property, $this->dataCast) &&
               $this->dataCast[$property] != $this->$property
            )
            {
                $modifiedData[$property] = $value;
            }
        }
        return $modifiedData;
    }

    /**
     * Сохранение данных в базу данных.
     * Пример:
     *      Создание новой записи
     *      php```
     *      $post = new Post();
     *      $post->title = 'Hello';
     *      $post->content = 'Data';
     *      $post->id_user = 1;
     *      $post->save();
     *      ```
     *      Обновление существующей записи
     *      php```
     *      $post = Post::query()->select()->where(['id' => 1])->one();
     *      $post->title = 'New';
     *      $post->save();
     *      ```
     * @return bool
     * @throws Exception
     */
    public function save()
    {
        if($this->isNewRecord())
        {
            return self::query()->insert($this->getDataCast())->execute();
        }
        /**
         * TODO: Переделать реализацию данной части метода
         * @start
         * @see https://trello.com/c/NE5skg8X/6-%D0%BF%D0%B5%D1%80%D0%B5%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C-%D1%80%D0%B5%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8E-%D0%B4%D0%B0%D0%BD%D0%BD%D0%BE%D0%B9-%D1%87%D0%B0%D1%81%D1%82%D0%B8-%D0%BC%D0%B5%D1%82%D0%BE%D0%B4%D0%B0
         */
        return self::query()->update($this->getModifiedData())->
                              where(['id' => $this->id])->
                              execute();
        /**
         * @end
         * */
    }

    /**
     * Установка таблицы для работы
     * @return string
     */
    public static function tableName()
    {
        return lcfirst(ObjectHelper::classNameWithoutNamespace(get_called_class()));
    }

    /**
     * Валидация данных
     * 
     * Данный метод получает данные для валидации
     * из метода rules
     * @see rules
     * 
     * @return bool
     */
    public function validate()
    {
        $this->errorStorage = new ErrorDataStorage();
        $validator = new Validator();

        return $validator->validate($this, $this->rules(), $this->errorStorage);
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errorStorage->hasErrors();
    }

    /**
     * Получение ошибок валидации
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errorStorage->getErrors();
    }

    /**
     * Получение первой ошибки валидации
     * 
     * @return string
     */
    public function firstError()
    {
        return $this->errorStorage->firstError();
    }

    /**
     * Правила валидации
     * 
     * @return array
     */
    protected function rules()
    {
        return [];
    }
}