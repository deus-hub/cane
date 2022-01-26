<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HomeOwnersRequest extends FormRequest
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
            'location_of_risk'                      => 'required|string',
            'other_location_of_risk'                => 'nullable|string',
            'single_article_limit'                  => 'required|numeric',
            'excess'                                => 'required|numeric',
            'address_of_property'                   => 'required|string',
            'type_of_building'                      => 'required|numeric',
            'number_of_bedrooms'                    => 'required|numeric',
            'year_built'                            => 'required|numeric',
            'claims_description'                    => 'required|string',
            'owned'                                 => ['required', Rule::in(['true', 'false'])],
            'mortgaged'                             => ['required', Rule::in(['true', 'false'])],
            'claims_history'                        => ['required', Rule::in(['true', 'false'])],
            'alternative_accommodation_required'    => ['required', Rule::in(['true', 'false'])],
            'alternative_accommodation_limit'       => 'required|numeric',
            'all_risk_cover_required'               => ['required', Rule::in(['true', 'false'])],
            'all_risk_limit'                        => 'required|numeric',
            'home_content_required'                 => ['required', Rule::in(['true', 'false'])],
            'home_content_sum_insured'              => 'required|numeric',
            'sum_insured'                           => 'required|numeric',
            'insured_type'                          => 'required|string',
            'addon_id'                              => 'required|numeric',
            'addon_key'                             => 'required|numeric',
            'addon_value'                           => 'required|numeric',
            'addon_value_type'                      => 'required|string',
            'risk_image_name'                       => 'required|string',
            'risk_image_url'                        => 'nullable|url',
            'product_uid'                           => 'required|string',
            'policy_start_date'                     => 'required|date',
            'policy_end_date'                       => 'required|date',
            'firstname'                             => 'required|string',
            'lastname'                              => 'required|string',
            'address1'                              => 'required|string',
            'address2'                              => 'required|string',
            'city'                                  => 'required|string',
            'state'                                 => 'required|string',
            'local_government'                      => 'required|string',
            'identity_image_url'                    => 'nullable|url',
            'gender'                                => 'required|string',
            'marital_status'                        => 'required|string',
            'birthdate'                             => 'required|date',
            'title'                                 => 'required|string',
            'occupation'                            => 'required|string',
            'phone_number'                          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'email'                                 => 'required|email',
            'industry_sector'                       => 'required|string',
            'currency'                              => 'required|string',
        ];
    }
}
