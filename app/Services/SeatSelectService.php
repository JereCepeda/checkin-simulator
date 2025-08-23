<?php

namespace App\Services;

use App\Models\Flight;
use App\Services\GetBoardingPassService;

class SeatSelectService
{

    protected $getPassengerService;
    protected $seatService;
    protected $groupPassengerService;
    protected $getBoardingPassService;

    public function __construct(SeatService $seatService,
                                GetBoardingPassService $getBoardingPassService,
                                GroupPassengerService $groupPassengerService,
                                GetPassengerService $getPassengerService){

        $this->getPassengerService = $getPassengerService;
        $this->seatService = $seatService;
        $this->groupPassengerService = $groupPassengerService;
        $this->getBoardingPassService = $getBoardingPassService;
    }
    
    public function execute($flightId)
    {
        $flight= Flight::where('flight_id',$flightId)->first();
        $airplane = $flight->airplane;
        
        $asignaciones= $this->seatService->assignSeats($flight->passengers,$airplane->airplane_id);
        return $asignaciones;
    }
}