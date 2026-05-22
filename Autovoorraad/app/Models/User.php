<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name',
    'email',
    'role',
    'password',
    'logo',
    'kleur',
    'telefoonnummer',
    'plaats',
    'adres',
    'postcode',
    'hero_foto',
    'hero_beschrijving',
    'public_id',
    'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory,HasUuids, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function autos()
    {
        return $this->hasMany(Auto::class);
    }

    /**
     * Generate UUIDs for both primary id and public_id on create.
     */
    public function uniqueIds(): array
    {
        return ['id', 'public_id'];
    }
    public function isPremium(): bool
    {
        return $this->role === 'premium';
    }
}
