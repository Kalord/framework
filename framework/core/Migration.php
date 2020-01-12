<?php

namespace app\framework\core;

use app\framework\components\db\ddl\ColumnBuilder;
use app\framework\components\db\ddl\DDLQuery;
use app\console\models\Migration as Model;
use app\framework\helpers\ObjectHelper;

/**
 * Базовый класс для миграций
 * 
 * Для того, чтобы создать миграцию, необходимо выполнить следующую команду:
 *      php console/index.php migrate/create create_user_table
 * В данном случае, будет создана миграция для таблицы user
 * В общем случае команда выглядит следующим образом:
 *      php console/index.php migrate/create create_name_table
 * Где name - это название таблицы
 * 
 * После выполнения данной команды, будет создана миграционный класс по следующему пути:
 *      console\migrations\create_user_table.php
 * Данный миграционный класс, должен содержать два метода:
 *      up(),
 *      down()
 * Данные методы выполняют действия с базой данных.
 * После выполнения миграций, в базе данных будет создана таблица с миграциями:
 *      migration:
 *      +++++++++++++++++++
 *      + name +   time   +
 *      +++++++++++++++++++
 * Это история миграций, поле name содержит название миграции, а time - дату
 * ее применения
 * 
 * Исходя из вышеописанного примера, после исполнения миграций, командой:
 *      console/index.php migrate/up
 * Будет создана таблица user, и отмечена в истории миграций следующим образом:
 *      ++++++++++++++++++++++++++++++++++
 *      + name              +   time     +
 *      ++++++++++++++++++++++++++++++++++
 *      + create_user_table + 1578759411 +
 *      ++++++++++++++++++++++++++++++++++
 * 
 * Пример создания таблицы:
 *      class create_user_table extends Migration
 *      {
 *          public function up()
 *          {
 *              $this->createTable('user', [
 *                  'id' => $this->primaryKey(),
 *                  'login' => $this->string(30)->notNull(),
 *                  'password' => $this->string()->notNull()
 *              ]);
 *          }
 *      }
 * Более подробно об API миграций
 * @see console/migrations/create_example_table.php
 * 
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class Migration
{
    /**
     * @var object
     */
    private $columnBuilder;

    /**
     * @var object
     */
    private $DDLQuery;

    /**
     * @var string
     */
    private $statusMessage;

    public function __construct()
    {
        $this->columnBuilder = new ColumnBuilder();
        $this->DDLQuery = new DDLQuery();

        $this->DDLQuery->createTable('migration', [
            'id INT NOT NULL PRIMARY KEY',
            'name VARCHAR(255) NOT NULL',
            'time INT NOT NULL'
        ]);
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
    }

    /**
     * Данный метод срабатывает перед созданием таблицы
     */
    public function beforeCreate()
    {
        $nameMigration = ObjectHelper::classNameWithoutNamespace(get_called_class());
        if(Model::findByName($nameMigration))
        {
            $this->setStatusMessage("Migration $nameMigration is relevant\n");
            return false;
        }
        return true;
    }

    /**
     * Данный метод срабатывает после создания таблицы
     */
    public function afterCreate()
    {
        $nameMigration = ObjectHelper::classNameWithoutNamespace(get_called_class());

        $model = new Model();
        $model->name = $nameMigration;
        $model->time = time();
        $model->save();

        $this->setStatusMessage("Migration with name $nameMigration execute\n");
    }

    /**
     * @param string $tableName
     * @param array $options
     */
    public function createTable($tableName, array $options)
    {
        if(!$this->beforeCreate()) return $this->getStatusMessage();

        $columns = [];
        $columnNames = array_keys($options);
        $columnSql = $this->columnBuilder->getColumns();

        for($i = 0; $i < count($columnNames); $i++)
        {
            $columnName = $columnNames[$i];
            $sql = $columnSql[$i];

            $columns[] = "$columnName $sql";
        }

        if($this->DDLQuery->createTable($tableName, $columns)) $this->afterCreate();

        return $this->getStatusMessage();
    }

    /**
     * @param string $tableName
     */
    public function dropTable($tableName)
    {

    }

    /**
     * Устанавливает определенную колонку первичным ключом
     */
    public function primaryKey()
    {
        $this->columnBuilder->createPrimaryKey();
    }
}