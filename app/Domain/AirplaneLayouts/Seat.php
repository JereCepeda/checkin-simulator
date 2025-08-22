<?php
namespace App\Domain\AirplaneLayouts;

use App\Models\SeatType;

class Seat
{
    public string $fila;
    public int $columna;
    public int $numero;
    public string $clase;
    public function __construct(string $fila,int $columna,int $numero, $clase)
    {
        $this->fila = $fila;
        $this->columna = $columna;
        $this->numero = $numero;
        $this->clase = $clase;
    }
    public function __toString():string
    {
        return "{$this->fila}{$this->columna} ({$this->numero}) - {$this->clase}";
    }
}