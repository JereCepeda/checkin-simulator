<?php

namespace App\Domain\AirplaneLayouts;

use App\Domain\AirplaneLayouts\LayoutAvionStrategy;


class LayoutAirplane1 implements LayoutAvionStrategy
{

    public function generarMapa(): array
    {
        $asientos =[];
        $filas = range('A','G');
        foreach ($filas as $fila){
            if(in_array($fila,['C','D','E'])) continue;
            for ($col = 1; $col <=4 ; $col++){
                $asientos[] = new Seat($fila,$col,$col,'Primera clase');
            }
        }
        $num = 8;
        foreach ($filas as $fila){
            if($fila==='D') continue;
            for ($col = 1; $col <=8 ; $col++){
                $asientos[] = new Seat($fila,$col,$num,'Clase económica premium');
            }
            $num++;
        }
        $num = 19;
        foreach ($filas as $fila){
            if($fila==='D') continue;
            for ($col = 1; $col <=16 ; $col++){
                $asientos[] = new Seat($fila,$col,$num,'Clase económica');
            }
            $num++;
        }
        
        return $asientos;
    }
}