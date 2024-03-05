<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementCheque extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $table = 'reglement_cheques';
    protected $fillable = [
        'date_reglement',
        'cheque_id',
        'compte_id',
        'benefiiaire_id',
        'service_id',
        'montant',
        'echeance',
        'referance',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reglementSiniAuto()
    {
        return $this->hasMany(ReglementSiniAuto::class, 'reglement_cheque_id', 'id');
    }
    public function reglementRdp()
    {
        return $this->hasMany(ReglementSiniRdp::class,  'reglement_cheque_id', 'id');
    }
    public function reglementFournisseur()
    {
        return $this->hasMany(ReglementFournisseur::class,  'reglement_cheque_id', 'id');
    }
    public function reglementCltRistourne()
    {
        return $this->hasMany(ReglementCltRistourn::class,  'reglement_cheque_id', 'id');
    }

    public function cheque()
    {
        return $this->belongsTo(Check::class, 'cheque_id');
    }
    public function compte()
    {
        return $this->belongsTo(CompteDepense::class, 'compte_id', 'id');
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
        return ReglementCheque::with('images')->orderBy('created_at', 'desc')->get();
    }
    public function RelChequeImages()
    {
        return $this->hasMany(ReglementChequeImage::class);
    }
}
