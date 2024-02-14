<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effet extends Model
{
    use HasFactory;
    protected $table = 'effets';
    protected $fillable = [
        'effet_series',
        'effet_sie',
        'effet_number',
        'carnet_effet_id',
        'user_id',
    ];
    // protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function carnet_effet()
    {
        return $this->belongsTo(CarnetEffet::class);
    }

    public function reglementEffet()
    {
        return $this->hasOne(ReglementEffet::class, 'effet_id');
    }
    // public function effetDebit()
    // {
    //     return $this->hasMany(EffetDebit::class, 'check_id');
    // }
    // public function effetAnnule()
    // {
    //     return $this->hasMany(EffetAnnule::class, 'check_id');
    // }
}
