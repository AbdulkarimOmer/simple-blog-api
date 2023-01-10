<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snowflake\SnowflakeCast;
use Snowflake\Snowflakes;

class User extends Model
{
    use  HasFactory, Snowflakes;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => SnowflakeCast::class,
        'email_verified_at' => 'datetime',
    ];
}
