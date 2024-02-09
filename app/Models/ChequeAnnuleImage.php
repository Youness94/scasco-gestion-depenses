<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeAnnuleImage extends Model
{
    use HasFactory;

    protected $table = 'check_annules_images';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function checkAnnule()
    {
        return $this->belongsTo(CheckAnnule::class, 'check_annule_id');
    }
}
