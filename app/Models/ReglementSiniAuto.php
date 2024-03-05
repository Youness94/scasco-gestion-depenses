<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementSiniAuto extends Model
{
    use HasFactory;

    protected $table = 'reglements_siniautos';
    protected $fillable = [
        'companier_id',
        'referance_dossier_auto',
        'referance_quittance_auto',
        'reglement_cheque_id',
        
    ];
    // protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function reglementCheque()
    {
        return $this->belongsTo(ReglementCheque::class);
    }

    public function companier()
    {
        return $this->belongsTo(Compagnie::class, 'companier_id', 'id');
    }
}
