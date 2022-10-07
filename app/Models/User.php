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
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'otp',
        'BVN',
        'bank',
        'account_number',
        'pension_program'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function naya_capitals()
    {
        return $this->hasMany(NayaCapital::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function insurances()
    {
        return $this->hasMany(Insurance::class);
    }
}
