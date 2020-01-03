<?php
/**
 * Конфигурационный файл для приложения
 */
return [
    'router' => [
        'package' => 'app\framework\core\Router',
        'baseController' => 'app\framework\core\Controller',
        'packageControllers' => 'app\controllers\\',
        'dispatcherInterface' => 'app\framework\core\IDispatcher'
    ]
];