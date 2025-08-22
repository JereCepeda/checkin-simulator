<?php

namespace App\Http\Controllers;

use App\Models\Flight;


use Illuminate\Http\Request;
use App\Services\SeatSelectService;

use Illuminate\Database\Eloquent\Casts\Json;

class FlightController extends Controller
{
    protected $seatSelectService;
    /**
     * Class constructor.
     */
    public function __construct(SeatSelectService $seatSelectService)
    {
        $this->seatSelectService = $seatSelectService;
    }
    public function checkin(Request $request){
        
        $seleccion = $this->seatSelectService->execute($request->route('id'));
        return response()->json(['message'=> 'Asiento asignado con exito']);
    }



    public function convertKeysToCamelCase(array $array): array {
        $result = [];
        foreach ($array as $clave => $value) {

            $newKey = is_string($clave) ? $this->snakeToCamel($clave) : $clave;
            if (is_array($value)) {
                $result[$newKey] = $this->convertKeysToCamelCase($value);
            } else {
                $result[$newKey] = $value;
            }
        }

    return $result;
    }
    public function snakeToCamel($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

        
    public function show($flightId) {
        $flight = Flight::findOrFail($flightId);
        $response = Json::encode([
            'code' => 200,
            'data' => [
                'id' => $flight->flight_id,
                'takeoff_date_time'=> $flight->takeoff_date_time,
                'takeoff_airport' =>$flight->takeoff_airport,
                'landing_date_time' =>$flight->landing_date_time,
                'landing_airport' =>$flight->landing_airport,
                'airplane_id' =>$flight->airplane_id
            ],
        ]);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }
   
    public function showPassengers($flightId){
        $flight = Flight::findOrFail($flightId);
        return response([
            'code'=>200,
            'data' => $this->convertKeysToCamelCase([
                    'id' => $flight->flight_id,
                    'takeoffDateTime'=> $flight->takeoff_date_time,
                    'takeoffAirport' =>$flight->takeoff_airport,
                    'landing_date_time' =>$flight->landing_date_time,
                    'landing_airport' =>$flight->landing_airport,
                    'airplane_id' =>$flight->airplane_id,
            ])
        ]);

    }
}
