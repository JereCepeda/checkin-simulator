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

    public function __construct(SeatService $seatService,GetBoardingPassService $getBoardingPassService,GroupPassengerService $groupPassengerService,GetPassengerService $getPassengerService){
        $this->getPassengerService = $getPassengerService;
        $this->seatService = $seatService;
        $this->groupPassengerService = $groupPassengerService;
        $this->getBoardingPassService = $getBoardingPassService;
    }
    
    public function execute($id)
    {
        $flight= Flight::where('flight_id',$id)->first();
        $airplane = $flight->airplane;
        $grupo = $this->groupPassengerService->getGroupPurchase($flight->flight_id);
        // $boardingPass = $this->getBoardingPassService->execute($request);
        
        $this->seatService->searchSeat($grupo,$airplane->airplane_id);

        return "";
    }
}