<?php

namespace RhysLeesLtd\Camelot;

use Illuminate\Support\Arr;

class Area
{
    public function __construct(
        protected int $xTopLeft,
        protected int $yTopLeft,
        protected int $xBottomRight,
        protected int $yBottomRight,
    ) {}

    public function xTopLeft(): int
    {
        return $this->xTopLeft;
    }

    public function yTopLeft(): int
    {
        return $this->yTopLeft;
    }

    public function xBottomRight(): int
    {
        return $this->xBottomRight;
    }

    public function yBottomRight(): int
    {
        return $this->yBottomRight;
    }

    public function coords(): string
    {
        return Arr::join([
            $this->xTopLeft,
            $this->yTopLeft,
            $this->xBottomRight,
            $this->yBottomRight,
        ], ',');
    }
}