<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckAnnule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function checkbook()
    {
        return $this->belongsTo(Checkbook::class);
    }

    public function reglementCheque()
    {
        return $this->hasOne(ReglementCheque::class,'cheque_id');
    }
    public function check()
    {
        return $this->belongsTo(Check::class, 'check_id');
    }

    public function ChequeAnnuleImages()
    {
        return $this->hasMany(ChequeAnnuleImage::class, 'check_annule_id');
    }
}
