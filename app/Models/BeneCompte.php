<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneCompte extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function compte_depense()
    {
        return $this->belongsTo(CompteDepense::class);
    } 

    public function reglementCheques()
    {
        return $this->hasMany(ReglementCheque::class, 'benefiiaire_id');
    }

    public function reglementEffets()
    {
        return $this->hasMany(ReglementEffet::class, 'benefiiaire_id');
    }
}
