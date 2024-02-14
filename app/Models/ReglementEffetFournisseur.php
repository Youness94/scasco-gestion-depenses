<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementEffetFournisseur extends Model
{
    use HasFactory;

    protected $table = 'reglement_effet_fournisseurs';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function reglementEffet()
    {
        return $this->belongsTo(ReglementEffet::class);
    }

    public function sousCompte()
    {
        return $this->belongsTo(SousCompte::class, 'sous_compte_id', 'id');
    }
}
