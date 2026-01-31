<?php

namespace RhysLeesLtd\Camelot\Exceptions;

abstract class NotSupportedException extends \Exception
{
    public function __construct(string $mode)
    {
        parent::__construct(sprintf('Processing mode "%s" does not support "%s". It can be used with "%s"', $mode, $this->featureName(), $this->validModesString()));
    }

    private function validModesString(): string
    {
        $validModes = $this->validModes();
        $modes = implode(' | ', $validModes);

        return count($validModes) > 1 ? $modes . ' modes' : $modes . ' mode';
    }

    abstract protected function validModes(): array;

    abstract protected function featureName(): string;
}