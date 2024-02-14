<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementEffetImage extends Model
{
    use HasFactory;
    protected $table = 'reglement_effet_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reglementEffet()
    {
        return $this->belongsTo(ReglementEffet::class);
    }
}
