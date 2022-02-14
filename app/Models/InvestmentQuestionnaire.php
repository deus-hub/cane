<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'percentage_withdrawal', 'investment_objective', 'initial_withdrawal ', 'investment_reliance ', 'dipp_reaction ', 'response ',
    ];
}
