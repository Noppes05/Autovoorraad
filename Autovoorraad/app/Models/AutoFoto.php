<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class AutoFoto extends Model
{
    use HasUuids;
     protected $table = 'auto_fotos';
    protected $fillable = [
        'auto_id',
        'foto_path',
        'volgorde_nummer',
    ];

     public function auto()
    {
        return $this->belongsTo(Auto::class);
    }
}
