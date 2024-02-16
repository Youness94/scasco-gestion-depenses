<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetDebitImage extends Model
{
    use HasFactory;

    protected $table = 'effet_debit_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function effetDebit()
    {
        return $this->belongsTo(EffetDebit::class,  'effet_debit_id');
    }
}
