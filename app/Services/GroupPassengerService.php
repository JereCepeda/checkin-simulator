<?php

namespace App\Services;

use App\Models\Flight;
use App\Models\Purchase;
use App\Models\BoardingPass;
use Illuminate\Support\Collection;

class GroupPassengerService
{
    public function getGroupPurchase(int $flight_id): Collection
    {
        $vuelo = Flight::findorfail($flight_id)->first();
        $grupos = $this->priorityGroupPurchase($vuelo);
        return $grupos;
    }
    public function priorityGroupPurchase($vuelo):Collection{
        //1era prioridad Menores
        //2da prioridad Grupos con purchase_id igual
        

        return $vuelo->purchases;
    }
}