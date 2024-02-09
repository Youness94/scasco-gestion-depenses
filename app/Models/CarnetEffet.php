<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarnetEffet extends Model
{
    use HasFactory;

    protected $table = 'carnet_effets';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function effets()
    {
        return $this->hasMany(Effet::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function effet_affectation()
    {
        return $this->hasOne(EffetAffectation::class);
    }
}
