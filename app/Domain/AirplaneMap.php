<?php

namespace App\Domain;

use App\Domain\AirplaneLayouts\LayoutAvionStrategy;

class AirplaneMap 
{
    private LayoutAvionStrategy $layout;

    public function __construct(LayoutAvionStrategy $layout)
    {
        $this->layout = $layout;
    }


    public function obtenerAsiento(): array
    {
        return $this->layout->generarMapa();
    }
}