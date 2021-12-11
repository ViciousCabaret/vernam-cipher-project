<?php

namespace App\Helpers;

abstract class AbstractVernamCipherTool
{


    const ALLOWED_CHARS = 'abcdefghijklmnopqrstuvwxyz!@#$%^&*()-_=+[{]};:,<.>/?| ';

//    const LETTERS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
//        'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '.', ',', '?', '{', '}', '[', ']', ';', ':', '<', '>', '/', '|', '_', '-', '+', '='];

    const MODULO_VALUE = 80;

    protected array $allowedChars = [];

    protected string $message;

    protected string $key;

    protected string $result;

    protected array $letterNumericValues;

    public function __construct(string $message, string $key)
    {
        $this->message = strtolower($message);
        $this->key = strtolower($key);
    }

    public function run(): self
    {
        $this->createCharactersArray();
        $comparedData = $this->compareMessageKey();
        $moduloOperation = $this->moduloOperation($comparedData);
        $this->createResults($moduloOperation);
        return $this;
    }

    private function createCharactersArray(): void
    {
        $this->allowedChars = str_split(self::ALLOWED_CHARS);
    }

    public function getResult(): string
    {
        return $this->result;
    }

    protected function moduloOperation(array $data): array
    {
        $result = [];
        foreach ($data as $number) {
            $result[] = $number % count($this->allowedChars);
        }

        return $result;
    }


    protected function createResults(array $data): void
    {
        $result = [];
        foreach ($data as $number) {
            $result[] = $this->allowedChars[$number];
        }

        $this->result = implode($result);
    }

    protected function compareMessageKey(): array
    {
        $result = [];
        $splittedKey = str_split($this->key);
        $splittedMessage = str_split($this->message);
        foreach ($splittedMessage as $k => $letter) {
            if (count($splittedKey) <= $k) {
                $result[] = array_search($letter, $this->allowedChars);
                continue;
            }

            $result[] = $this->modifyLetterValue(
                array_search($letter, $this->allowedChars),
                array_search($splittedKey[$k], $this->allowedChars),
            );
        }
        return $result;
    }

    protected abstract function modifyLetterValue(int $letterValue, int $keyValue);
}