<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id',
        'merk',
        'model',
        'kenteken',
        'prijs',
        'km_stand',
        'bouwjaar',
        'beschrijving',
        'status',])]
class Auto extends Model
{
      public function bedrijf()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fotos()
    {
        return $this->hasMany(AutoFoto::class);
    }

    public function proefritten()
    {
        return $this->hasMany(Proefrit::class);
    }
}
