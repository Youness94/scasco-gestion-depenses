<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetDebit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function carnet_effet()
    {
        return $this->belongsTo(CarnetEffet::class);
    }

    public function reglementEffet()
    {
        return $this->hasOne(ReglementEffet::class);
    }

    public function effet()
    {
        return $this->belongsTo(Effet::class, 'effet_id');
    }

    public function EffetDebitImages()
    {
        return $this->hasMany(EffetDebitImage::class, 'effet_debit_id');
    }
}
