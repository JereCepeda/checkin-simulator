<?php
namespace App\Domain\AirplaneLayouts;

interface LayoutAvionStrategy
{
    public function generarMapa(): array; 
}