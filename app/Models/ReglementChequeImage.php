<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementChequeImage extends Model
{
    use HasFactory;
    protected $table = 'reglement_cheques_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reglementCheque()
    {
        return $this->belongsTo(ReglementCheque::class);
    }
}
