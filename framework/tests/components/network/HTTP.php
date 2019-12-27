<?php
require '../../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use app\framework\core\App;

/**
 * Тестирование компонента для работы с HTTP
 * @see framework/components/network/HTTP.php
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class HTTP extends TestCase
{
    /**
     * Компонент для работы с HTTP
     * @var object
     */
    private $component;

    protected function setUp(): void
    {
        $this->component = App::component('../../../../configs/components.php')->http;
    }

    public function testMethodGet()
    {
        $this->assertIsArray($this->component->request()->get());
        $this->assertNull($this->component->request()->get('foo'));
    }

    public function testMethodPost()
    {
        $this->assertIsArray($this->component->request()->post());
        $this->assertNull($this->component->request()->post('foo'));
    }
}