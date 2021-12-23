<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensionProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'pension_program',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
