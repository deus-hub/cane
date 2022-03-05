<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exchange'                  => 'required|string',
            'firstname'                 => 'required|string',
            'lastname'                  => 'required|string',
            'middlename'                => 'nullable|string',
            'gender'                    => 'required|string',
            'dob'                       => 'required|date',
            'email'                     => 'required|email',
            'phone'                     => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:14',
            'mothersMaidenname'         => 'nullable|string',
            'street'                    => 'required|string',
            'city'                      => 'required|string',
            'state'                     => 'required|string',
            'country'                   => 'required|string',
            'postcode'                  => 'required|string',
            'nationality'               => 'required|string',
            'stateOfOrigin'             => 'required|string',
            'lgaOfOrigin'               => 'required|string',
            'chn'                       => 'nullable|string',
            'nextOfKinName'             => 'required|string',
            'nextOfKinRelationship'     => 'nullable|string',
            'nextOfKinAddress'          => 'nullable|string',
            'nextOfKinPhone'            => 'required|string',
            'nextOfKinCHN'              => 'nullable|string',
            'bank'                      => 'required|string',
            'bankAccountName'           => 'required|string',
            'bankAccountNumber'         => 'required|string',
            'dateAccountOpened'         => 'required|string',
            'bvn'                       => 'required|string',
            'currency'                  => 'nullable|string',
            'kycTier'                   => 'nullable|string',
        ];
    }
}
