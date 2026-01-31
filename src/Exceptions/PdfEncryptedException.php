<?php

namespace RhysLeesLtd\Camelot\Exceptions;

class PdfEncryptedException extends \Exception
{
    public function __construct(string $filePath)
    {
        parent::__construct(sprintf('The PDF "%s" is encrypted and cannot be read without a password. Supply a password with $camelot->password(\'my_password\').', $filePath));
    }
}