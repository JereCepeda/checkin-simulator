<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   Log::info('Welcome route accessed');
    return view('welcome');
});
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');

Route::get('flights/{id}', [FlightController::class, 'show'])->name('flights.show');

Route::get('/buscar-vuelo', function (\Illuminate\Http\Request $request) {
    $id = $request->input('flight_id');
    return redirect()->route('flights.checkin', ['id' => $id]);
})->name('buscar.vuelo');

Route::get('/flights/{id}/passengers', [FlightController::class, 'checkin'])->name('flights.checkin');
// Route::get('/boardingPass', [FlightController::class, 'getBoardingPass'])->name('GET_BoardingPass');