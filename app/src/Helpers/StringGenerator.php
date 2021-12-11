<?php

namespace App\Helpers;

class StringGenerator
{

    public static function generate(int $length = 10): string
    {
        $charactersLength = strlen(AbstractVernamCipherTool::ALLOWED_CHARS);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= AbstractVernamCipherTool::ALLOWED_CHARS[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}