<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable([
        'auto_id',
        'foto_path',
        'volgorde_nummer',
    ])]
class AutoFoto extends Model
{
     protected $table = 'auto_fotos';

     public function auto()
    {
        return $this->belongsTo(Auto::class);
    }
}
