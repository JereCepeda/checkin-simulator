<?php

namespace App\Services;

use App\Models\Flight;
use Illuminate\Support\Collection;

class GroupPassengerService
{
    public function getGroupPurchase(int $flight_id): Collection
    {
        $flight = Flight::findorfail($flight_id)->first();
        
        return $flight;
    }
}