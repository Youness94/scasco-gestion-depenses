<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetAnnule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function carnet_effet()
    {
        return $this->belongsTo(CarnetEffet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    public function benef()
    {
        return $this->belongsTo(BeneCompte::class, 'benefiiaire_id', 'id');
    }

    public function compte()
    {
        return $this->belongsTo(EffetCompte::class, 'effet_compte_id', 'id');
    }

    public function reglementEffet()
    {
        return $this->hasOne(ReglementEffet::class,'effet_id');
    }
    public function effet()
    {
        return $this->belongsTo(Effet::class, 'effet_id');
    }

    public function EffetAnnuleImages()
    {
        return $this->hasMany(EffetAnnuleImage::class, 'effet_annule_id');
    }
}
