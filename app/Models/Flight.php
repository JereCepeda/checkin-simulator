<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        'takeoff_date_time',
        'takeoff_airport',
        'landing_date_time',
        'landing_airport',
        'airplane_id',
    ];

    protected $table = 'flight'; 
    protected $primaryKey = 'flight_id';

    public function boardingPasses()
    {
        return $this->hasMany(BoardingPass::class, 'flight_id', 'flight_id');
    }

    public function airplane(){
        return $this->belongsTo(Airplane::class,'airplane_id','airplane_id');
    }

    public function purchases()
    {
        return $this->hasManyThrough(Purchase::class,BoardingPass::class,'flight_id','purchase_id','flight_id','purchase_id');
    }

    public function passengers()
    {
        return $this->hasManyThrough(Passenger::class,BoardingPass::class,'flight_id','passenger_id','flight_id','passenger_id');
    }

}