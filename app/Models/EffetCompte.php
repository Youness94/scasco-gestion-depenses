<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetCompte extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    // public function bene_compte()
    // {
    //     return $this->hasMany(BeneCompte::class);
    // } 

    // public function reglementEffets()
    // {
    //     return $this->hasMany(ReglementEffet::class, 'compte_effet_id');
    // }
}
