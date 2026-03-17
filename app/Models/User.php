<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'avatar',
        'points',
        'theme',
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
            'points' => 'integer',

        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("{$this->name} {$this->father_lastname} {$this->mother_lastname}")
        );
    }

    protected function getUserName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->username}"
        );
    }

    protected function getUserPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->points}"
        );
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar) {
                    // Predefined avatars are now stored as full URLs or relative assets
                    if (str_starts_with($this->avatar, 'http') || str_starts_with($this->avatar, '/assets')) {
                        return str_starts_with($this->avatar, 'http') ? $this->avatar : asset(ltrim($this->avatar, '/'));
                    }
                    
                    if (str_starts_with($this->avatar, 'avatars/')) {
                        return asset('storage/' . $this->avatar);
                    }
                    
                    return asset('images/avatars/' . $this->avatar);
                }

                // If no avatar, pick a random default based on their ID to keep it consistent per user
                // Let's fetch one from the known arrays; for simplicity we will fallback to a generated avatar or one of the known balls
                $defaults = ['assets/wc-balls/1930.png', 'assets/wc-fifa-logos/1930.jpg', 'assets/country-teams-shields/Mexico.png'];
                $index = $this->id % max(count($defaults), 1);
                return asset($defaults[$index]);
            }
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
