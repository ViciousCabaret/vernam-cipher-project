<?php

namespace App\Helpers;

abstract class AbstractValidator
{

    /**
     * @param string $chars
     * @return bool
     */
    protected function validateCharacters(string $chars): bool
    {
        foreach (str_split($chars) as $char) {
            if (!in_array($char, str_split(AbstractVernamCipherTool::ALLOWED_CHARS))) {
                return false;
            }
        }
        return true;
    }
}