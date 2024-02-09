<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckDebit extends Model
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
        return $this->hasOne(ReglementCheque::class);
    }

    public function check()
    {
        return $this->belongsTo(Check::class, 'check_id');
    }

    public function ChequeDebitImages()
    {
        return $this->hasMany(ChequeDebitImage::class, 'cheque_debit_id');
    }

}
