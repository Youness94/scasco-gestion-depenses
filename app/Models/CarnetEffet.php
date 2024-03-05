<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarnetEffet extends Model
{
    use HasFactory;

    protected $table = 'carnet_effets';
    protected $fillable = [
        'reception_date',
        'carnet_series',
        'bank_id',
        'effet_sie',
        'effet_start_number',
        'effet_quantity',
        'user_id',
        'validation',
    ];


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
