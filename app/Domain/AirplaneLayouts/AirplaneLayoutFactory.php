<?php

namespace App\Domain\AirplaneLayouts;

use App\Domain\AirplaneLayouts\LayoutAvionStrategy;


class AirplaneLayoutFactory
{
    public function make(int $airplaneId): LayoutAvionStrategy
    {
        return match ($airplaneId) {
            1 => new LayoutAirplane1(),
            2 => new LayoutAirplane2(),
            default => throw new \InvalidArgumentException("Layout no definido para avión {$airplaneId}")
        };
    }
}
