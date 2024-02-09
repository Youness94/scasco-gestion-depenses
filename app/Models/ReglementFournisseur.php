<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementFournisseur extends Model
{
    use HasFactory;

    protected $table = 'reglements_frss';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function reglementCheque()
    {
        return $this->belongsTo(ReglementCheque::class);
    }

    public function sousCompte()
    {
        return $this->belongsTo(SousCompte::class, 'sous_compte_id', 'id');
    }
}
