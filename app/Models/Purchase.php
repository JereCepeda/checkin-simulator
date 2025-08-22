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
    
    public function boardingPass(){
        return $this->hasMany(boardingPass::class);
    }

}
