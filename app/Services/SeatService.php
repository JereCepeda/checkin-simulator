<?php

namespace App\Services;

use App\Domain\AirplaneLayouts\AirplaneLayoutFactory;
use App\Domain\AirplaneMap;

class SeatService
{
    protected AirplaneLayoutFactory $layoutFactory;

    public function __construct(AirplaneLayoutFactory $layoutFactory) {
        $this->layoutFactory = $layoutFactory;
    }

    public function searchSeat($grupo,$airplaneId)
    {   
        $strategy = $this->layoutFactory->make($airplaneId);
        $map = (new AirplaneMap($strategy))->obtenerAsiento();
        info(json_encode($grupo));
        return [];
    }
}