<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbook extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function checks()
    {
        return $this->hasMany(Check::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function affectation()
    {
        return $this->hasOne(Affectation::class);
    }
    



}
