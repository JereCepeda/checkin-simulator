<?php

namespace App\Services;

use App\Models\Seat;
use App\Models\BoardingPass;
use Illuminate\Support\Collection;
use Mockery\Generator\StringManipulation\Pass\Pass;

class SeatService
{

    public function getSeatsForAirplane(int $airplaneId):Collection {

        $occupiedSeatIds = BoardingPass::whereNotNull('seat_id')->pluck('seat_id')->toArray();
        return Seat::where('airplane_id', $airplaneId)->whereNotIn('seat_id', $occupiedSeatIds)->get();    
    }
    
    public function assignSeats(Collection $passengers, int $airplaneId)
    {
        $availableSeats = $this->getSeatsForAirplane($airplaneId);
        $assignments = [];
        $this->assignMinorWhitAdults($passengers,$availableSeats,$assignments);
        $this->assignGroups($passengers,$availableSeats,$assignments);
        $this->assignIndividuals($passengers,$availableSeats,$assignments);
        return $assignments;
    }    

    private function assignMinorWhitAdults(Collection $passengers, Collection &$availableSeats,array &$assignments )  {
        foreach($passengers as $minor){
            if($minor->age <18 && !isset($minor->boardingPasses->seat_id)){
                $adult = $passengers->first(function ($candidate) use ($minor) {
                    return $candidate->purchase_id === $minor->purchase_id
                        && $candidate->age >= 18
                        && !$candidate->boardingPasses->first()->seat_id;
                });
                if($adult){
                    foreach($availableSeats as $seat){
                        $contiguousSeat = $this->findContiguousSeat($seat,$availableSeats);
                        if($contiguousSeat){
                            $this->assignPassengerToSeat($adult,$seat,$availableSeats,$assignments);
                            $this->assignPassengerToSeat($minor,$contiguousSeat,$availableSeats,$assignments);
                            break;
                        }
                    }
                }
            }
        }
    }
    private function assignGroups(Collection $passengers, Collection &$availableSeats, array &$assignments){
        $grouped = $passengers->groupBy('purchase_id');
        foreach($grouped as $group){
            if($group->count() >1 ){
                foreach($group as $groupMember){
                    if(!$groupMember->boardingPasses->firstWhere('passenger_id',$groupMember->passenger_id)->seat_id && $availableSeats->count() >=2){
                        $seat = $this->findSeatSameColumn($availableSeats);
                        if($seat){
                            $contiguousSeat = $this->findContiguousSeat($seat,$availableSeats);
                            if($contiguousSeat){
                                $this->assignPassengerToSeat($groupMember,$seat,$availableSeats,$assignments);
                                $this->assignPassengerToSeat($group->firstWhere('passenger_id','!=',$groupMember->passenger_id),$contiguousSeat,$availableSeats,$assignments);
                                break;
                            }
                        }else{
                            info('No hay asientos disponibles en la misma columna para el grupo '.$group->first()->purchase_id);
                            break;
                        }
                        
                    }
                }
            }
        }
    }
    private function assignIndividuals(Collection $passengers, Collection &$availableSeats, array &$assignments){
        foreach ($passengers as $p) {
            if (!$p->boardingPasses->firstWhere('passenger_id',$p->passenger_id)->seat_id && $availableSeats->isNotEmpty()) {
                $seat = $availableSeats->shift();
                $this->assignPassengerToSeat($p, $seat, $availableSeats, $assignments);
            }
        }
    }

    private function assignPassengerToSeat($passenger, Seat $seat, Collection &$availableSeats, array &$assignments): void
    {

        $passenger->boardingPasses->firstWhere('passenger_id',$passenger->passenger_id)->seat_id = $seat->seat_id;
        $passenger->boardingPasses->firstWhere('passenger_id',$passenger->passenger_id)->save();
        $assignments[$passenger->passenger_id] = $seat->seat_id;
        $availableSeats = $availableSeats->reject(fn($s) => $s->seat_id === $seat->seat_id);
    }

    private function findSeatSameColumn(Collection $availableSeats): ?Seat
    {
        if ($availableSeats->isEmpty()) {
            return null;
        }

        $column = $availableSeats->groupBy('seat_column')
            ->sortByDesc(fn($g) => $g->count())
            ->keys()
            ->first();

        return $availableSeats->firstWhere('seat_column', $column);
    }
    public function areSeatsContiguous(Seat $s1, Seat $s2): bool
    {
        if ($s1->seat_row !== $s2->seat_row) {
            return false;
        }
        $diff = abs(ord($s1->seat_column) - ord($s2->seat_column));
        return $diff === 1;
    }
    public function findContiguousSeat(Seat $seat, Collection $availableSeats): ?Seat
    {
        return $availableSeats->first(fn($s) => $this->areSeatsContiguous($seat, $s));
    }

}