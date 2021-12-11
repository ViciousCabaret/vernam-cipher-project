<?php

namespace App\Helpers;

class VernamEncryptionTool extends AbstractVernamCipherTool
{

    public function __construct(string $message, string $key)
    {
        parent::__construct($message, $key);
    }

    public function encrypt(): self
    {
        return parent::run();
    }

    protected function modifyLetterValue(int $letterValue, int $keyValue): int
    {
        return $letterValue + $keyValue;
//        return $this->letterNumericValues[$letter] + $this->letterNumericValues[$splittedKey[$k]];
    }
}