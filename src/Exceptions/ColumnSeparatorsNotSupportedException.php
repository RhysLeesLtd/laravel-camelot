<?php

namespace RhysLeesLtd\Camelot\Exceptions;

use RhysLeesLtd\Camelot\Camelot;

class ColumnSeparatorsNotSupportedException extends NotSupportedException
{
    protected function validModes(): array
    {
        return [
            Camelot::MODE_STREAM,
        ];
    }

    protected function featureName(): string
    {
        return 'column separators';
    }
}