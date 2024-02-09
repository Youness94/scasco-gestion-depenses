<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function reglementCheques()
    {
        return $this->hasMany(ReglementCheque::class, 'service_id');
    }

    public function checkbooks()
    {
        return $this->hasMany(Checkbook::class, 'checkbook_id');
    }


}
