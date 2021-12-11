<?php

namespace App\Helpers;

class VernamValidator
{

    private string $string = '';


    public function getMessageValidator(): VernamMessageValidator
    {
        return new VernamMessageValidator();
    }

    public function getKeyValidator(): VernamKeyValidator
    {
        return new VernamKeyValidator();
    }


}