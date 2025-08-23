<?php

namespace App\Http\Controllers;

use App\Models\Flight;


use Illuminate\Http\Request;
use App\Services\SeatSelectService;

use Illuminate\Support\Facades\Log;
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
        $start = microtime(true);
        Log::info("Inicio de ejecución checkin", [
            'flightId' => $request->route('id'),
            'time' => $start
        ]);

        try {
            $flight = Flight::find($request->route('id'));

            if (!$flight) {
                return response([
                    "code" => 404,
                    "data" => (object)[]
                ], 404);
            }

            // Ejecutar lógica de asignación de asientos
            $this->seatSelectService->execute($flight->flight_id);

            $response = response([
                'code' => 200,
                'data' => $this->convertKeysToCamelCase([
                    'flight_id'        => $flight->flight_id,
                    'takeoff_date_time'=> $flight->takeoff_date_time,
                    'takeoff_airport'  => $flight->takeoff_airport,
                    'landing_date_time'=> $flight->landing_date_time,
                    'landing_airport'  => $flight->landing_airport,
                    'airplane_id'      => $flight->airplane_id,
                    'passengers'       => $flight->passengers->toArray()
                ])
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error en checkin", [
                'flightId' => $request->route('id'),
                'error'    => $e->getMessage()
            ]);

            $response = response([
                'code' => 400,
                'errors' => "could not connect to db"
            ], 400);
        }

        $end = microtime(true);
        $elapsed = $end - $start;
        Log::info("Fin de ejecución checkin", [
            'flightId' => $request->route('id'),
            'duration_seconds' => $elapsed
        ]);

        return $response;
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
