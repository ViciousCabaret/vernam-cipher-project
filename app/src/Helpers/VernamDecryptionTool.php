<?php

namespace App\Helpers;

class VernamDecryptionTool extends AbstractVernamCipherTool
{
    public function __construct(string $message, string $key)
    {
        parent::__construct($message, $key);
    }

    public function decode()
    {
        return parent::run();
    }

    public function encode()
    {
        $this->generateLettersNumericValues();
        $comparedData = $this->compareMessageKey();
        $moduloOperation = $this->moduloOperation($comparedData);
        $this->createResults($moduloOperation);
    }

    protected function modifyLetterValue(int $letterValue, int $keyValue): int
    {
        return $letterValue - $keyValue < 0 ? ($letterValue - $keyValue) + count($this->allowedChars) : $letterValue - $keyValue;
    }
}