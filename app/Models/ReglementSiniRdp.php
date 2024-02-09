<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementSiniRdp extends Model
{
    use HasFactory;


    protected $table = 'reglements_sinirdps';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function reglementCheque()
    {
        return $this->belongsTo(ReglementCheque::class);
    }

    public function companier()
    {
        return $this->belongsTo(Compagnie::class, 'companier_id', 'id');
    }
}
