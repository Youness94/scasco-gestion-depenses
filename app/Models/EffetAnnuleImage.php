<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EffetAnnuleImage extends Model
{
    use HasFactory;

    protected $table = 'effet_annule_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function effetAnnule()
    {
        return $this->belongsTo(EffetAnnule::class, 'effet_annule_id');
    }
}
