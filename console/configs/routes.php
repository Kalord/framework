<?php
/**
 * Маршруты для роутера
 * Данный конфигурационный файл хранит пару:
 *      'url' => 'controller/action'
 * Пример:
 * Определена следующая пара:
 *      '/settings' => 'user/settings'
 * Тогда, при запросе: http://site.local/settings
 * Будет запущен следующий маршрут: $UserController->actionSettings();
 *
 * Передача аргументов в действие осуществляется по определенным масками:
 *      <int>       - Передача числа
 *      <string>    - Передача строки
 * Пример:
 *      'post/<int>' => 'post/detail'
 * Тогда, при запросе: http://site.local/post/1
 * Будет запущен следующий маршрут: $PostController->actionDetail(1);
 */
return [
    'post/<int>' => 'post/detail'
];