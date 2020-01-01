<?php

namespace app\framework\core;

use Exception;
use app\framework\core\IDispatcher;
use app\framework\core\App;
use app\framework\core\View;

/**
 * Базовый класс для контроллеров
 * @package app\framework\core
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
abstract class Controller implements IDispatcher
{
    /**
     * Путь до директории с видами
     * @var string
     */
    protected $directoryWithViews = 'views';

    /**
     * Путь до шаблона
     * @var string
     */
    protected $layout = 'views/layout/main.php';

    /**
     * @var object
     */
    private $view;

    public function __construct()
    {
        $this->view = new View($this->directoryWithViews, $this->layout);
    }

    /**
     * Данный метод получает набор классов диспетчеров и выполняет их каждый раз при запуске действия
     *
     * Пример:
     *      php```
     *      public function userDispatch()
     *      {
     *          return [
     *              'app\core\dispatcher\User' => [
     *                  'actions' => ['login', 'registration', 'profile', 'logout'],
     *                  'rules' => [
     *                      'canGuest' => [
     *                          'login', 'registration'
     *                      ],
     *                      'canUser' => [
     *                          'profiler', 'logout'
     *                      ]
     *                  ]
     *              ]
     *          ]
     *      }
     *      ```
     *
     * @inheritDoc
     * @return void
     */
    public function dispatch()
    {
        var_dump('In dispatch');
    }

    /**
     * Переадресация на определенный url
     *
     * @param string $url
     * @param void
     * @throws Exception
     */
    protected function redirect($url)
    {
        App::component()->http->redirect($url);
    }

    /**
     * Переадресация на главную страницу
     *
     * @return void;
     * @throws Exception
     */
    protected function goHome()
    {
        $this->redirect('/');
    }

    /**
     * Данный метод отображает вид
     * Интерфейс для взаимодействия с view
     * @see app\framework\core\View
     *
     * Данный метод получает название вида
     * и осуществляет поиск в директории views -> поддиректории соответсвующей названию контроллера
     * @default директория со всеми видами - views
     * Например:
     *      php```
     *      class PostController extends Controller
     *      {
     *          public function actionIndex()
     *          {
     *              return $this->render('index');
     *          }
     *      }
     *      ```
     * В данном примере, поиск view будет осуществляются по следующему пути: views/post/index.php
     * директорию с видами можно поменять, переопределив свойство $directoryWithViews
     *
     * Передача данных в вид, происходит с помощью ассоциативного массива
     * ['nameDataUnitInView' => $currentDataUnit];
     * Например:
     *      php```
     *      class PostController extends Controller
     *      {
     *          public function actionDetail($id)
     *          {
     *              return $this->render('index', [
     *                  'post' => Post::get($id)
     *              ]);
     *          }
     *      }
     *      ```
     * В данном примере, в вид попадет объект ActiveRecord $post
     *
     * @param string $viewName
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function render($viewName, array $data = [])
    {
        return $this->view->prepareView($viewName, get_class($this), $data);
    }
}