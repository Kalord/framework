<?php

namespace app\framework\helpers;

/**
 * Помощник для работы с HTML
 * @package app\framework\helpers
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class HtmlHelper
{
    /**
     * @const int
     */
    const NOT_CLOSED = 1;

    /**
     * @const int
     */
    const CLOSED = 2;

    /**
     * Создание HTML элемента
     * Пример:
     *      php```
     *      HtmlHelper::create(
     *          'div',
     *          HtmlHelper::CLOSED,
     *          [
     *              'class' => 'container'
     *          ],
     *          'Hello, World!'
     *      );
     *      ```
     * В данном примере будет создана следующая строка: <div class="container">Hello, World!</div>
     *
     * @param string $tagName
     * @param int $closed
     * @param array $attributes
     * @param string|null $content
     * @return string
     */
    public static function create($tagName, $closed, array $attributes, $content = null)
    {
        $html = "<$tagName ";
        foreach ($attributes as $attributeName => $attributeValue)
        {
            $html .= "$attributeName=\"$attributeValue\" ";
        }
        $html .= '>';
        if($content) $html .= $content;
        if($closed == self::CLOSED) $html .= "</$tagName>";

        return $html . "\n";
    }
}