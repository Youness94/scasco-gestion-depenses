<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'images' => 'array'
    ];

    public function gettest(){
        return Affectation::with('images')->orderBy('created_at', 'desc')->get();

    }
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }
    public function checkbook()
    {
        return $this->belongsTo(Checkbook::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function courtier()
    {
        return $this->belongsTo(Courtier::class);
    }

    public function images()
    {
        return $this->hasMany(AffectationImage::class);
    }
}
