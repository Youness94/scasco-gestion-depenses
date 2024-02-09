<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
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
        return $this->hasOne(ReglementCheque::class, 'cheque_id');
    }
    public function chequeDebit()
    {
        return $this->hasMany(CheckDebit::class, 'check_id');
    }
    public function chequeAnnule()
    {
        return $this->hasMany(CheckAnnule::class, 'check_id');
    }
}
