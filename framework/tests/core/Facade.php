<?php
require '../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use app\framework\core\App;
use app\framework\components\network\HTTP;

/**
 * Тестирование фасада для компонентов
 * @see framework/core/App.php
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class Facade extends TestCase
{
    /**
     * Получение доступа к компоненту
     * @throws Exception
     */
    public function testAccessComponent()
    {
        $component = App::component('../../../configs/components.php')->http;
        $this->assertTrue($component instanceof HTTP, '\app\framework\components\HTTP');
    }

    /**
     * Получение доступа к методу
     * @throws Exception
     */
    public function testAccessMethod()
    {
        $this->assertIsArray(App::component('../../../configs/components.php')->http->request()->get());
    }
}