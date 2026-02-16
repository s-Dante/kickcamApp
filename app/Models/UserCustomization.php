<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class UserCustomization extends Model
{
    /** @use HasFactory<\Database\Factories\UserCustomisationFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'skin_color',
        'shirt_color',
        'pants_color',
        'avatar_setup_data',
        'user_id'
    ];

    protected $casts = [
        'skin_color' => 'string',
        'shirt_color' => 'string',
        'pants_color' => 'string',
        'avatar_setup_data' => 'json'
    ];

    public  function getSkinColor()
    {
        return $this->skin_color;
    }

    public  function getShirtColor()
    {
        return $this->shirt_color;
    }

    public  function getPantsColor()
    {
        return $this->pants_color;
    }

    public  function getAvatarSetupData()
    {
        return $this->skin_color;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
