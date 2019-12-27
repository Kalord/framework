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
    ]
];