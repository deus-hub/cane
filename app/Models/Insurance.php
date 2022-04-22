<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'broker', 'quote_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
