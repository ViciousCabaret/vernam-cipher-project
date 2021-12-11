<?php

namespace App\Helpers;

use Exception;

class VernamKeyValidator extends AbstractValidator
{

    public function validate(string $key): void
    {
        if (!$this->validateCharacters($key)) {
            throw new Exception('Key contains illegal characters');
        }
    }

//    /**
//     * @param string $key
//     * @return bool
//     */
//    private function (string $key): bool
//    {
//        foreach (str_split($key) as $char) {
//            if (!in_array($char, str_split(AbstractVernamCipherTool::ALLOWED_CHARS))) {
//                return false;
//            }
//        }
//        return true;
//    }
}