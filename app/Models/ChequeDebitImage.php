<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeDebitImage extends Model
{
    use HasFactory;
    protected $table = 'check_debit_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function checkDebit()
    {
        return $this->belongsTo(CheckDebit::class,  'cheque_debit_id');
    }
}
