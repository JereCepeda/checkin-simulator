<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardingPass extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'purchase_id',
        'passenger_id',
        'seat_type_id',
        'seat_id',
        'flight_id',
    ];

    protected $table = 'boarding_pass'; 
    protected $primaryKey = 'boarding_pass_id';
    
    public function passenger():BelongsTo
    {
        return $this->belongsTo(Passenger::class, 'passenger_id','boarding_pass_id');
    }
    public function flight():BelongsTo
    {
        return $this->belongsTo(Flight::class,'flight_id','boarding_pass_id');
    }
     public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'purchase_id');
    }
    
    public function passengers()
    {
        return $this->hasManyThrough(Passenger::class,BoardingPass::class,'flight_id','passenger_id','flight_id','passenger_id');
    }
    
}
