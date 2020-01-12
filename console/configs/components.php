<?php
/**
 * Конфигурационный файл для работы с компонентами
 * Данный конфигурационный файл нужен для фасада компонентов
 * Пример:
 *      Чтобы получить доступ к компоненту http, необходимо сделать следующий конфигурационный файл configs/components.php:
 *          ```php
 *          return [
 *              'http' => [
 *                  'package' => 'app\\components\\HTTP'
 *              ]
 *          ]
 *          ```
 *      Теперь, чтобы получить доступ к компоненту, достаточно:
 *          ```php
 *          App::component()->http;
 *          ```
 */
return [
    'http' => [
        'package' => '\app\framework\components\network\HTTP'
    ],
    'cookie' => [
        'package' => '\app\framework\components\Cookie'
    ],
    'user' => [
        'package' => '\app\framework\components\user\User',
        'identity' => '\app\models\User'
    ],
    'fileTemplate' => [
        'package' => '\app\framework\components\FileTemplate'
    ],
    'message' => [
        'package' => '\app\framework\components\ConsoleMessage'
    ]
];