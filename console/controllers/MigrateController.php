<?php

namespace app\console\controllers;

use app\framework\core\App;
use app\framework\core\Controller;
use app\framework\helpers\FileHelper;

class MigrateController extends Controller
{
    public function actionCreate($migrateName)
    {
        if(!FileHelper::directoryExists('migrations'))
        {
           FileHelper::createDirectory('migrations');
        }
        
        $file = FileHelper::createFile("migrations/$migrateName.php");
        $matches = [];

        if(preg_match('~create_(\w+)_table~', $migrateName, $matches))
        {
            if(fwrite($file, App::component()->fileTemplate->createTable(
                $migrateName, 
                $matches[1]
            )))
            {
                App::component()->message->successMessage("$migrateName created\n");
            }
        }
    }

    public function actionUp()
    {
        $migrations = array_slice(FileHelper::getFilesInDirectory('migrations/'), 2);

        if(empty($migrations))
        {
            App::component()->message->successMessage("Migrate not found\n");
            return;
        }

        foreach($migrations as $migration) 
        {
            $migration = preg_replace('~.php~', '', $migration);
            $migration = "app\\console\\migrations\\$migration";
            App::component()->message->successMessage((new $migration())->up());
        }
    }

    public function actionDown()
    {
        $migrations = array_slice(FileHelper::getFilesInDirectory('migrations/'), 2);

        if(empty($migrations))
        {
            App::component()->message->successMessage("Migrate not found\n");
            return;
        }

        foreach($migrations as $migration) 
        {
            $migration = preg_replace('~.php~', '', $migration);
            $migration = "app\\console\\migrations\\$migration";
            App::component()->message->successMessage((new $migration())->down());
        }
    }
}