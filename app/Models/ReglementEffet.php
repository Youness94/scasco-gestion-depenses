<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementEffet extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function reglementEffetFournisseur()
    {
        return $this->hasMany(ReglementEffetFournisseur::class,  'reglement_effet_id', 'id');
    }
    // public function reglementEffetCies()
    // {
    //     return $this->hasMany(reglementEffetCies::class,  'reglement_effet_id', 'id');
    // }

    public function effet()
    {
        return $this->belongsTo(Effet::class, 'effet_id');
    }
    public function effet_compte()
    {
        return $this->belongsTo(EffetCompte::class, 'effet_compte_id', 'id');
    }
    public function bene()
    {
        return $this->belongsTo(BeneCompte::class, 'benefiiaire_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    
    public function gettest()
    {
        return ReglementEffet::with('images')->orderBy('created_at', 'desc')->get();
    }
    public function RelEffetImages()
    {
        return $this->hasMany(ReglementEffetImage::class);
    }
}
