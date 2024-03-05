<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbook extends Model
{
    use HasFactory;
    // protected $guarded = [];
 protected $table = 'checkbooks';
    protected $fillable = [
        'reception_date',
        'series',
        'bank_id',
        'cheque_sie',
        'start_number',
        'quantity',
        'user_id',
        'validation',
    ];
    
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
