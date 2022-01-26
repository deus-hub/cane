<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotorInsuranceRequest extends FormRequest
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
            'usage'                                 => 'required|string',
            'flood_cover_required'                  => ['required', Rule::in(["true", "false"])],
            'excess_buy_back_value'                 => 'required|numeric',
            'vehicle_replacement_required'          => ['required', Rule::in(['true', 'false'])],
            'tracker_discount_enabled'              => ['required', Rule::in(['true', 'false'])],
            'tracker_required'                      => ['required', Rule::in(["true", "false"])],
            'tracker_amount'                        => 'required|numeric',
            'vehicle_registration_number'           => 'required|string',
            'make_of_vehicle'                       => 'required|string',
            'vehicle_model'                         => 'required|string',
            'year_of_make'                          => 'required|numeric',
            'location_of_risk'                      => 'required|string',
            'other_location_of_risk'                => 'nullable|string',
            'chasis_number'                         => 'required|string',
            'engine_number'                         => 'required|string',
            'vehicle_type'                          => 'required|string',
            'video_url'                             => 'nullable|url',
            'tracker_installed'                     => ['required', Rule::in(['true', 'false'])],
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
