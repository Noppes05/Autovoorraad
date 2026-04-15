<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'auto_id',
    'naam',
    'email',
    'telefoonnummer',
    'datum_tijd',
    'bericht',
    'status',
])]
class Proefrit extends Model
{
    public function auto()
    {
        return $this->belongsTo(Auto::class);
    }

    public function bedrijf()
    {
        return $this->auto->bedrijf();
    }
}
