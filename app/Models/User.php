<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //public $timestamps = false; // i dont want created_at and updated_at
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'suspended',
        'firstname',
        'lastname',
        'phone_code',
        'phone',
        'is2fa',
        'is2fa_code',
        'device_token',
        'email_verified_at',
        'city',
        'state',
        'address',
        'pics',
        'files',
        'verified',
        'remember_token',
        'google_id',
        'facebook_id',
        'persona_inquiry_id',
        'bank_details',
    ];

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
        'email_verified_at' => 'datetime',
    ];
}
