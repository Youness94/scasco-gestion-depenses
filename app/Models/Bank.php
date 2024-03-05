<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $table = 'banks';
    protected $fillable = [
        'nom',
    ];
    public function checkbooks()
    {
        return $this->hasMany(Checkbook::class);
    }
}
