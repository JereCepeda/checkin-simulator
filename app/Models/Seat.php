<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{

    use HasFactory;
    protected $table = 'seat';
    protected $primaryKey = 'seats_id';
    protected $fillable = [
        'seat_row',
        'seat_column',
        'airplane_id',
        'seat_type_id',
    ];
    public function airplane() {
        return $this->belongsTo(Airplane::class, 'airplane_id', 'airplane_id');
    }
    public function type()
    {
        return $this->belongsTo(SeatType::class, 'seat_type_id', 'seat_type_id');
    }
}
