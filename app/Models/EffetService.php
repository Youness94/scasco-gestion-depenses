<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetService extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    // public function reglementEffets()
    // {
    //     return $this->hasMany(ReglementEffet::class, 'effet_service_id');
    // }

    public function carnet_effets()
    {
        return $this->hasMany(CarnetEffet::class, 'carnet_effet_id');
    }
}
