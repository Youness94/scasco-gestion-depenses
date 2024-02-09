<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetAffectation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'images' => 'array'
    ];

    public function gettest(){
        return EffetAffectation::with('images')->orderBy('created_at', 'desc')->get();

    }
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function effet_affectation()
    {
        return $this->belongsTo(EffetAffectation::class);
    }
    public function carnet_effet()
    {
        return $this->belongsTo(CarnetEffet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function courtier()
    {
        return $this->belongsTo(Courtier::class);
    }

    public function effet_images()
    {
        return $this->hasMany(EffetAffectationImage::class);
    }
}
