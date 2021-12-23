<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'firstname', 'lastname', 'email', 'phone', 'BVN',
        'bank', 'firstname', 'account_number', 'pension_program'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
