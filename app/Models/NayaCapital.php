<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NayaCapital extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange', 'genericPassThruParam', 'refCode', 'kycRefNo', 'firstname', 'lastname', 'middlename', 'gender', 'dob', 'email', 'phone', 'mothersMaidenname', 'street', 'city', 'state', 'country', 'postcode', 'nationality', 'stateOfOrigin', 'lgaOfOrigin', 'chn', 'nextOfKinName', 'nextOfKinRelationship', 'nextOfKinAddress', 'nextOfKinPhone', 'nextOfKinCHN', 'bank', 'bankAccountName', 'bankAccountNumber', 'dateAccountOpened', 'bvn', 'currency', 'kycTier'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
