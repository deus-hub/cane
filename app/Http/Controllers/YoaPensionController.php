<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeOwnersRequest;
use App\Http\Requests\MotorInsuranceRequest;
use App\Models\YoaPension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Double;

class YoaPensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get active products
        $activeProducts = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
        ])
            ->get(config('services.yoa.base_url') . '/api/Integration/GetActiveProducts')
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'ActiveProducts' => $activeProducts,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetDetails($quoteNumber)
    {
        //get active products
        $productDetails = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
        ])
            ->get(config('services.yoa.base_url') . '/api/Integration/GetQuoteStatus?quoteNumber=' . $quoteNumber)
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'ProductDetails' => $productDetails,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AllRiskQuote(Request $request)
    {
        $fields = $request->validate([
            'country'               => 'required|string|max:100|min:3',
            'sum_insured'           => 'required|numeric',
            'product_uid'           => 'required|string',
            'policy_start_date'     => 'required|date',
            'policy_end_date'       => 'required|date',
            'firstname'             => 'required|string|max:100|min:3',
            'lastname'              => 'required|string|max:100|min:3',
            'address1'              => 'required|string',
            'address2'              => 'required|string',
            'city'                  => 'required|string',
            'state'                 => 'required|string',
            'local_government'      => 'required|string',
            'gender'                => 'required|string',
            'marital_status'        => 'required|string',
            'birth_date'            => 'required|date',
            'title'                 => 'required|string',
            'occupation'            => 'required|string',
            'phone_number'          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'email'                 => 'required|email',
            'industry_sector'       => 'required|string',
            'currency'              => 'required|string',
        ]);

        $payload = [
            "RiskDetails" => [[
                "AllRiskDetails" => [
                    "LocationOfRisk"        => $fields['country'],
                    "OtherLocationOfRisk"   => "",
                    "Excess"                => 5,
                    "VideoUrl"              => "www.theVideo.url.com/myvideo"
                ],
                "SumInsured"    => $fields['sum_insured'],
                "InsuredType"   => "MainContact",
                "RiskImages" => [[
                    "Filename"  => "RiskImage.jpg",
                    "Image"     => ""
                ]],
                "InsuredName"       => $fields['firstname'] . ' ' . $fields['lastname']
            ]],
            "ProductUid"            => $fields['product_uid'],
            "PolicyStartDate"       => $fields['policy_start_date'],
            "PolicyEndDate"         => $fields['policy_end_date'],
            "Account" => [
                "FirstName"         => $fields['firstname'],
                "LastName"          => $fields['lastname'],
                "AddressLine1"      => $fields['address1'],
                "AddressLine2"      => $fields['address2'],
                "City"              => $fields['city'],
                "StateName"         => $fields['state'],
                "Lga"               => $fields['local_government'],
                "IdentityImage"     => "",
                "Gender"            => $fields['gender'],
                "MaritialStatus"    => $fields['marital_status'],
                "BirthDate"         => $fields['birth_date'],
                "Title"             => $fields['title'],
                "Position"          => $fields['occupation'],
                "Phone"             => $fields['phone_number'],
                "Email"             => $fields['email'],
                "IndustrySector"    => $fields['industry_sector'],
                "FullName"          => $fields['firstname'] . ' ' . $fields['lastname'],
                "ThirdpartyAccountUid" => "00000000-0000-0000-0000-000000000000",
                "CreatePolicyholder"            => false,
                "IdentificationImageRequired"   => false,
                "QuestionFileDocumentImages"    => []
            ],
            "Payment" => [
                "Currency" => $fields['currency']
            ]
        ];

        $allRiskQuote = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.yoa.base_url') . '/api/Integration/GetQuoteAllRiskInsurance',
                $payload
            );

        // Log::info($allRiskQuote);
        return response()->json(
            [
                'status' => 'true',
                'Quote' => json_decode($allRiskQuote),
                // 'ActiveProducts' => $allRiskQuote,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function MotorInsurance(MotorInsuranceRequest $request)
    {
        $payload = [
            "RiskDetails" => [
                [
                    "ComprehensiveMotorDetails" => [
                        "Usage"                         => $request['usage'],
                        "FloodCoverRequired"            => $request['flood_cover_required'],
                        "ExcessBuyBackValue"            => $request['excess_buy_back_value'],
                        "VehicleReplacementRequired"    => $request['vehicle_replacement_required'],
                        "TrackerDiscountEnabled"        => $request['tracker_discount_enabled'],
                        "TrackerRequired"               => $request['tracker_required'],
                        "TrackerAmount"                 => $request['tracker_amount'],
                        "VehicleRegistrationNumber"     => $request['vehicle_registration_number'],
                        "MakeOfVehicle"                 => $request['make_of_vehicle'],
                        "OtherMakeOfVehicle"            => "Required if MakeOfVehicle = Other",
                        "VehicleModel"                  => $request['vehicle_model'],
                        "YearOfMake"                    => $request['year_of_make'],
                        "LocationOfRisk"                => $request['location_of_risk'],
                        "OtherLocationOfRisk"           => $request['other_location_of_risk'],
                        "ChassisNumber"                 => $request['chasis_number'],
                        "EngineNumber"                  => $request['engine_number'],
                        "VehicleType"                   => $request['vehicle_type'],
                        "VideoUrl"                      => $request['video_url'] ?? '',
                        "TrackerInstalled"              => $request['tracker_installed']
                    ],
                    "SumInsured"        => $request['sum_insured'],
                    "InsuredType"       => $request['insured_type'],
                    "AddonAnswers" => [
                        [
                            "ID"            => $request['addon_id'],
                            "Key"           => $request['addon_key'],
                            "Value"         => $request['addon_value'],
                            "ValueTypeText" => $request['addon_value_type']
                        ]
                    ],
                    "RiskImages" => [
                        [
                            "Filename"  => $request['risk_image_name'],
                            "Image"     => $request['risk_image_url'] ?? ''
                        ]
                    ],
                    "InsuredName" => $request['firstname'] . ' ' . $request['lastname']
                ]
            ],
            "ProductUid"                 => $request['product_uid'],
            "PolicyStartDate"            => $request['policy_start_date'],
            "PolicyEndDate"              => $request['policy_end_date'],
            "Account" => [
                "FirstName"                 => $request['firstname'],
                "LastName"                  => $request['lastname'],
                "AddressLine1"              => $request['address1'],
                "AddressLine2"              => $request['address2'],
                "City"                      => $request['city'],
                "StateName"                 => $request['state'],
                "Lga"                       => $request['local_government'],
                "IdentityImage"             => $request['identity_image_url'] ?? '',
                "Gender"                    => $request['gender'],
                "MaritialStatus"            => $request['marital_status'],
                "BirthDate"                 => $request['birthdate'],
                "Title"                     => $request['title'],
                "Position"                  => $request['occupation'],
                "Phone"                     => $request['phone_number'],
                "Email"                     => $request['email'],
                "IndustrySector"            => $request['industry_sector'],
                "FullName"                  => $request['firstname'] . ' ' . $request['lastname'],
                "ThirdpartyAccountUid"      => "00000000-0000-0000-0000-000000000000",
                "CreatePolicyholder"        => false,
                "IdentificationImageRequired" => false,
                "QuestionFileDocumentImages" => []
            ],
            "Payment" => [
                "Currency" => $request['currency']
            ]
        ];


        $quote = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.yoa.base_url') . '/api/Integration/GetQuoteComprehensiveMotorInsurance',
                $payload
            );

        return response()->json(
            [
                'status' => 'true',
                'Quote' => json_decode($quote),
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function GroupHomeOwnersInsurance(HomeOwnersRequest $request)
    {
        $payload = [
            "RiskDetails" => [
                [
                    "HomeOwnersDetails" => [
                        "LocationOfRisk"                    => $request['location_of_risk'],
                        "OtherLocationOfRisk"               => $request['other_location_of_risk'] ?? '',
                        "SingleArticleLimit"                => $request['single_article_limit'],
                        "Excess"                            => $request['excess'],
                        "AddressOfProperty"                 => $request['address_of_property'],
                        "TypeOfBuilding"                    => $request['type_of_building'],
                        "NumberOfBedrooms"                  => $request['number_of_bedrooms'],
                        "YearBuilt"                         => $request['year_built'],
                        "ClaimsDescription"                 => $request['claims_description'],
                        "Owned"                             => $request['owned'],
                        "Mortgaged"                         => $request['mortgaged'],
                        "ClaimsHistory"                     => $request['claims_history'],
                        "AlternativeAccommodationRequired"  => $request['alternative_accommodation_required'],
                        "AlternativeAccommodationLimit"     => $request['alternative_accommodation_limit'],
                        "AllRiskCoverRequired"              => $request['all_risk_cover_required'],
                        "AllRiskLimit"                      => $request['all_risk_limit'],
                        "HomeContentRequired"               => $request['home_content_required'],
                        "HomeContentSumInsured"             => $request['home_content_sum_insured'],
                    ],
                    "SumInsured"        => $request['sum_insured'],
                    "InsuredType"       => $request['insured_type'],
                    "AddonAnswers" => [
                        [
                            "ID"            => $request['addon_id'],
                            "Key"           => $request['addon_key'],
                            "Value"         => $request['addon_value'],
                            "ValueTypeText" => $request['addon_value_type']
                        ]
                    ],
                    "RiskImages" => [
                        [
                            "Filename"  => $request['risk_image_name'],
                            "Image"     => $request['risk_image_url'] ?? ''
                        ]
                    ],
                    "InsuredName" => $request['firstname'] . ' ' . $request['lastname']
                ]
            ],
            "ProductUid"                 => $request['product_uid'],
            "PolicyStartDate"            => $request['policy_start_date'],
            "PolicyEndDate"              => $request['policy_end_date'],
            "Account" => [
                "FirstName"                 => $request['firstname'],
                "LastName"                  => $request['lastname'],
                "AddressLine1"              => $request['address1'],
                "AddressLine2"              => $request['address2'],
                "City"                      => $request['city'],
                "StateName"                 => $request['state'],
                "Lga"                       => $request['local_government'],
                "IdentityImage"             => $request['identity_image_url'] ?? '',
                "Gender"                    => $request['gender'],
                "MaritialStatus"            => $request['marital_status'],
                "BirthDate"                 => $request['birthdate'],
                "Title"                     => $request['title'],
                "Position"                  => $request['occupation'],
                "Phone"                     => $request['phone_number'],
                "Email"                     => $request['email'],
                "IndustrySector"            => $request['industry_sector'],
                "FullName"                  => $request['firstname'] . ' ' . $request['lastname'],
                "ThirdpartyAccountUid"      => "00000000-0000-0000-0000-000000000000",
                "CreatePolicyholder"        => false,
                "IdentificationImageRequired" => false,
                "QuestionFileDocumentImages" => []
            ],
            "Payment" => [
                "Currency" => $request['currency']
            ]
        ];


        $quote = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.yoa.base_url') . '/api/Integration/GetQuoteHomeOwnersAndHouseholdInsurance',
                $payload
            );

        return response()->json(
            [
                'status' => 'true',
                'Quote' => json_decode($quote),
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function HomeOwnersInsurance(HomeOwnersRequest $request)
    {
        $payload = [
            "RiskDetails" => [
                [
                    "HomeOwnersDetails" => [
                        "LocationOfRisk"                    => $request['location_of_risk'],
                        "OtherLocationOfRisk"               => $request['other_location_of_risk'] ?? '',
                        "SingleArticleLimit"                => $request['single_article_limit'],
                        "Excess"                            => $request['excess'],
                        "AddressOfProperty"                 => $request['address_of_property'],
                        "TypeOfBuilding"                    => $request['type_of_building'],
                        "NumberOfBedrooms"                  => $request['number_of_bedrooms'],
                        "YearBuilt"                         => $request['year_built'],
                        "ClaimsDescription"                 => $request['claims_description'],
                        "Owned"                             => $request['owned'],
                        "Mortgaged"                         => $request['mortgaged'],
                        "ClaimsHistory"                     => $request['claims_history'],
                        "AlternativeAccommodationRequired"  => $request['alternative_accommodation_required'],
                        "AlternativeAccommodationLimit"     => $request['alternative_accommodation_limit'],
                        "AllRiskCoverRequired"              => $request['all_risk_cover_required'],
                        "AllRiskLimit"                      => $request['all_risk_limit'],
                        "HomeContentRequired"               => $request['home_content_required'],
                        "HomeContentSumInsured"             => $request['home_content_sum_insured'],
                    ],
                    "SumInsured"        => $request['sum_insured'],
                    "InsuredType"       => $request['insured_type'],
                    "AddonAnswers" => [
                        [
                            "ID"            => $request['addon_id'],
                            "Key"           => $request['addon_key'],
                            "Value"         => $request['addon_value'],
                            "ValueTypeText" => $request['addon_value_type']
                        ]
                    ],
                    "RiskImages" => [
                        [
                            "Filename"  => $request['risk_image_name'],
                            "Image"     => $request['risk_image_url'] ?? ''
                        ]
                    ],
                    "InsuredName" => $request['firstname'] . ' ' . $request['lastname']
                ]
            ],
            "ProductUid"                 => $request['product_uid'],
            "PolicyStartDate"            => $request['policy_start_date'],
            "PolicyEndDate"              => $request['policy_end_date'],
            "Account" => [
                "FirstName"                 => $request['firstname'],
                "LastName"                  => $request['lastname'],
                "AddressLine1"              => $request['address1'],
                "AddressLine2"              => $request['address2'],
                "City"                      => $request['city'],
                "StateName"                 => $request['state'],
                "Lga"                       => $request['local_government'],
                "IdentityImage"             => $request['identity_image_url'] ?? '',
                "Gender"                    => $request['gender'],
                "MaritialStatus"            => $request['marital_status'],
                "BirthDate"                 => $request['birthdate'],
                "Title"                     => $request['title'],
                "Position"                  => $request['occupation'],
                "Phone"                     => $request['phone_number'],
                "Email"                     => $request['email'],
                "IndustrySector"            => $request['industry_sector'],
                "FullName"                  => $request['firstname'] . ' ' . $request['lastname'],
                "ThirdpartyAccountUid"      => "00000000-0000-0000-0000-000000000000",
                "CreatePolicyholder"        => false,
                "IdentificationImageRequired" => false,
                "QuestionFileDocumentImages" => []
            ],
            "Payment" => [
                "Currency" => $request['currency']
            ]
        ];


        $quote = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.yoa.base_url') . '/api/Integration/GetQuoteHomeOwnersInsurance',
                $payload
            );

        return response()->json(
            [
                'status' => 'true',
                'Quote' => json_decode($quote),
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function PayQuote(Request $request)
    {
        $fields = $request->validate([
            'quote_number'            => 'required|string',
            'payment_frequency'       => 'required|string',
            'payment_mode'            => 'required|string',
            'cheque_number'           => 'nullable|string',
            'amount'                  => 'required|string',
            'payment_recieved_date'   => 'required|date',
            'currency'                => 'required|string'
        ]);

        $payload = [

            "ThirdpartyAccountUid"      => "00000000-0000-0000-0000-000000000000",
            "QuoteNumber"               => $fields['quote_number'],
            "TargetOpportunityState"    => 0,
            "Payment" => [
                "PaymentFrequency"      => $fields['payment_frequency'],
                "PaymentMode"           => $fields['payment_mode'],
                "ChequeNumber"          => $fields['cheque_number'],
                "Amount"                => $fields['amount'],
                "PaymentReceivedDate"   => $fields['payment_recieved_date'],
                "Currency"              => $fields['currency']
            ]
        ];


        $quote = Http::withHeaders([
            'UserIdentity' => config('services.yoa.token'),
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.yoa.base_url') . '/api/Integration/PayQuote',
                $payload
            );

        if ($quote) {
            # commit to database
            auth()->user()->insurance()->create([
                'broker' => 'AIICO Insurance PLC',
                'quote_number' => $fields['quote_number']
            ]);

            return response()->json(
                [
                    'status' => 'true',
                    'Quote' => json_decode($quote),
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'false',
                    'message' => "unable to pay quote",
                ],
                500
            );
        }
    }
}
