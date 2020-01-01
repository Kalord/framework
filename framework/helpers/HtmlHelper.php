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
     * @param string $tagName
     * @param int $closed
     * @param array $attributes
     * @return string
     */
    public static function create($tagName, $closed, array $attributes)
    {
        $html = "<$tagName ";
        foreach ($attributes as $attributeName => $attributeValue)
        {
            $html .= "$attributeName=\"$attributeValue\" ";
        }
        $html .= '>';
        if($closed == self::CLOSED) $html .= "</$tagName>";

        return $html . "\n";
    }
}