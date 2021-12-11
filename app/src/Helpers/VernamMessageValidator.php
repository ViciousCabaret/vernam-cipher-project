<?php

namespace App\Helpers;

use Exception;

class VernamMessageValidator extends AbstractValidator
{

    /**
     * @param string|null $message
     * @return bool|null
     * @throws Exception
     */
    public function validate(?string $message): ?bool
    {
        if ($message == null || $message == '') {
            throw new Exception("Message is not defined");
        }
        if (!$this->validateCharacters($message)) {
            throw new Exception("Message contains illegal characters");
        }

        return true;
    }


//    /**
//     * @param string $msg
//     * @return bool
//     */
//    private function validateMessageCharacters(string $msg): bool
//    {
//        foreach (AbstractVernamCipherTool::ALLOWED_CHARS as $char) {
//            if (strpos($msg, $char) !== false) {
//                return false;
//            }
//        }
//        return true;
//    }
}