<?php

namespace RhysLeesLtd\Camelot;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Areas
{
    protected array $areas = [];

    public static function from($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight): static
    {
        $areas = new static;
        $areas->push(new Area($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight));

        return $areas;
    }

    public function add($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight): self
    {
        $this->areas[] = new Area($xTopLeft, $yTopLeft, $xBottomRight, $yBottomRight);

        return $this;
    }

    public function push(Area $area): self
    {
        $this->areas[] = $area;

        return $this;
    }

    public function toDelimitedString(string $join): string
    {
        $coords = Collection::make($this->areas)
            ->map(fn (Area $area) => $area->coords())
            ->all();

        return $join . Arr::join($coords, $join);
    }
}