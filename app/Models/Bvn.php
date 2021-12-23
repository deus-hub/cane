<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bvn extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'BVN',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
