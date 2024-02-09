<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckbookSerie extends Model
{
    use HasFactory;
    
    protected $fillable = ['serie_checkbook', 'checkbook_serie_q'];
    public function checkbookserie()
    {
        return $this->hasMany(Check::class);
    }
}
