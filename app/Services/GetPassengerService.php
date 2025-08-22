<?php

namespace App\Services;

use App\Models\Passenger;

class GetPassengerService
{
    public function execute(string $dni): ?Passenger
    {
        return Passenger::where('dni', $dni)->first();
    }
}