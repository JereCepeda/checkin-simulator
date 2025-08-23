<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passenger extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dni',
        'age',
        'country',
    ];
    protected $table = 'passenger'; 
    protected $primaryKey = 'passenger_id';
    public function boardingPasses()
    {
        return $this->hasMany(BoardingPass::class,'passenger_id','passenger_id');
    }
    public $timestamps = false; 
}
