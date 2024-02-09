<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetAffectationImage extends Model
{
    use HasFactory;
    
    protected $fillable = ['images', 'effet_affectation_id'];

    public function effet_affectation()
    {
        return $this->belongsTo(EffetAffectation::class);
    }
}
