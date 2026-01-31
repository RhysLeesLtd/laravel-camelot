<?php

namespace RhysLeesLtd\Camelot\Exceptions;

use RhysLeesLtd\Camelot\Camelot;

class BackgroundLinesNotSupportedException extends NotSupportedException
{
    protected function validModes(): array
    {
        return [
            Camelot::MODE_LATTICE,
        ];
    }

    protected function featureName(): string
    {
        return 'processing background lines';
    }

}