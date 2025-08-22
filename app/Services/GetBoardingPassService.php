<?php

namespace App\Services;

use App\Models\BoardingPass;

class GetBoardingPassService
{

    public function execute($request)
    {
        $boardingPass = BoardingPass::where('flight_id',$request->flight_id)->first();
        return $boardingPass;
    }
}