<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'public_id',
        'merk',
        'model',
        'kenteken',
        'prijs',
        'km_stand',
        'bouwjaar',
        'beschrijving',
        'status',
    ];

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

    /**
     * Generate UUIDs for both primary id and public_id on create.
     */
    public function uniqueIds(): array
    {
        return ['id', 'public_id'];
    }
}
