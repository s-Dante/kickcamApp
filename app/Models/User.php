<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\UserCustomization;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'father_lastname',
        'mother_lastname',
        'username',
        'email',
        'password',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

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
            'two_factor_confirmed_at' => 'datetime',
            'name' => 'string',
            'father_lastname' => 'string',
            'mother_lastname' => 'string',
            'points' => 'integer'

        ];
    }

    protected function getFullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->name} {$this->father->lastname} {$this->mother_lastname}"
        );
    }

    protected function getUserName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->username}"
        );
    }

    protected function getUserPoints(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->points}"
        );
    }

    public function customization(): HasOne
    {
        return $this->hasOne(UserCustomization::class, 'id', 'id');
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }
}
