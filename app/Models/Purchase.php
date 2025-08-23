<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchase';
    protected $primaryKey = 'purchase_id';
    protected $fillable = [
        'purchase_date'
    ];
    
    public function boardingPasses()
    {
        return $this->hasMany(BoardingPass::class, 'purchase_id', 'purchase_id');
    }
    public function passengers()
    {
        return $this->hasManyThrough(Passenger::class,BoardingPass::class,'purchase_id','passenger_id','purchase_id','passenger_id');
    }

}
