<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectationImage extends Model
{
    use HasFactory;
    
    protected $fillable = ['image', 'affectation_id'];

    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }
}
