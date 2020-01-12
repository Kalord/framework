<?php

namespace app\framework\components;

/**
 * Компонент для создания шаблонов файлов
 * 
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class FileTemplate
{
    /**
     * Шаблон для миграции создания таблицы
     * 
     * Создаст миграционный класс $className для создания таблицы $tableName,
     * которая будет потомкам $baseMigration
     * 
     * @param string $className
     * @param string $tableName
     * @param string $baseMigration
     */
    public function createTable($className, $tableName, $baseMigration = '\app\framework\core\Migration')
    {
        return <<< EOT
        <?php

        namespace app\\console\\migrations;

        /**
         * Migrations for $tableName
         **/
        class $className extends $baseMigration
        {
            public function up()
            {
                return \$this->createTable('$tableName', [
                    'id' => \$this->primaryKey(),
                ]);
            }

            public function down()
            {
                return \$this->dropTable('$tableName');
            }
        }
        EOT;
    }
}