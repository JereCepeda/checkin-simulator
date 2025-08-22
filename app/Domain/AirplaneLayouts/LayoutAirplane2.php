<?php
namespace App\Domain\AirplaneLayouts;

use App\Domain\AirplaneLayouts\Seat;
use App\Domain\AirplaneLayouts\LayoutAvionStrategy;


class LayoutAirplane2 implements LayoutAvionStrategy{
    
    public function generarMapa(): array
    {
        $asientos =[];
        $filas = range('A','I');
        foreach ($filas as $fila){
            if (in_array($fila, ['B','C','D','F','G','H'])) continue;
            for ($col = 1; $col <=5 ; $col++){
                $asientos[] = new Seat($fila,$col,$col,'Primera clase');
            }
        }
        $num = 9;
        foreach ($filas as $fila){
            if (in_array($fila, ['C','G'])) continue;
            for ($col = 1; $col <=6 ; $col++){
                $asientos[] = new Seat($fila,$col,$num,'Clase económica premium');
            }
            $num++;
        }
        $num = 18;
        foreach ($filas as $fila){
            if (in_array($fila, ['C','G'])) continue;
            for ($col = 1; $col <=14 ; $col++){
                $asientos[] = new Seat($fila,$col,$num,'Clase económica');
            }
            $num++;
        }
        
        return $asientos;
    }
}