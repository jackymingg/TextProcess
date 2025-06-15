<?php

namespace App\Services;

class TextProcessorService
{
    /**
     * 處理文字操作
     *
     * @param string $text
     * @param array $operations
     * @return string
     */
    public function processText(string $text, array $operations): string
    {
        $result = $text;

        foreach ($operations as $operation) {
            switch ($operation) {
                case 'reverse':
                    $result = strrev($result);
                    break;
                
                case 'uppercase':
                    $result = strtoupper($result);
                    break;
                
                case 'lowercase':
                    $result = strtolower($result);
                    break;
                
                case 'remove_spaces':
                    $result = str_replace(' ', '', $result);
                    break;
                
                default:
                    throw new \InvalidArgumentException("不支援的操作: {$operation}");
            }
        }

        return $result;
    }
}