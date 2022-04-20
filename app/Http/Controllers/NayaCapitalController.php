<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycInfoRequest;
use App\Models\NayaCapital;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NayaCapitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetKycInformation()
    {

        $response = auth()->user()->naya_capitals()->get();

        return response()->json(
            [
                json_decode($response),
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetStateCodes()
    {

        $payload = [
            "ncpId" => config('services.naya.ncpid')
        ];

        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/utils_nigerianstates',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetBankCodes()
    {

        $payload = [
            "ncpId" => config('services.naya.ncpid')
        ];

        // return $payload;

        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/utils_nigerianbanks',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetLgaCodes(Request $request)
    {
        $fields = $request->validate([
            'state_ref'               => 'required|string'
        ]);

        $payload = [
            "ncpId"         => config('services.naya.ncpid'),
            "stateRefno"    => $fields['state_ref']
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/utils_nigerianlgas',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function KycInformation(KycInfoRequest $request)
    {
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $request['exchange'],
            "firstname"             => $request['firstname'],
            "lastname"              => $request['lastname'],
            "middlename"            => $request['middlename'],
            "gender"                => $request['gender'],
            "dob"                   => $request['dob'],
            "email"                 => $request['email'],
            "phone"                 => $request['phone'],
            "mothersMaidenname"     => $request['mothersMaidenname'],
            "street"                => $request['street'],
            "city"                  => $request['city'],
            "state"                 => $request['state'],
            "country"               => $request['country'],
            "postcode"              => $request['postcode'],
            "nationality"           => $request['nationality'],
            "stateOfOrigin"         => $request['stateOfOrigin'],
            "lgaOfOrigin"           => $request['lgaOfOrigin'],
            "chn"                   => $request['chn'],
            "nextOfKinName"         => $request['nextOfKinName'],
            "nextOfKinRelationship"     => $request['nextOfKinRelationship'],
            "nextOfKinAddress"          => $request['nextOfKinAddress'],
            "nextOfKinPhone"            => $request['nextOfKinPhone'],
            "nextOfKinCHN"              => $request['nextOfKinCHN'],
            "bank"                      => $request['bank'],
            "bankAccountName"           => $request['bankAccountName'],
            "bankAccountNumber"         => $request['bankAccountNumber'],
            "dateAccountOpened"         => $request['dateAccountOpened'],
            "bvn"                       => $request['bvn'],
            "currency"                  => $request['currency'],
            "kycTier"                   => $request['kycTier'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/kyc_introduceinvestor',
            $payload
        );

        if ($response->successful()) {
            if ($response['errors'] == []) {
                auth()->user()->naya_capitals()->create([
                    'exchange'              => $response['exchange'],
                    'genericPassThruParam'  => $response['genericPassThruParam'],
                    'refCode'               => $response['refCode'],
                    'kycRefNo'              => $response['kycRefNo'],
                    'firstname'             => $response['firstname'],
                    'lastname'              => $response['lastname'],
                    'middlename'            => $response['middlename'],
                    'gender'                => $response['gender'],
                    'dob'                   => $response['dob'],
                    'email'                 => $response['email'],
                    'phone'                 => $response['phone'],
                    'mothersMaidenname'     => $response['mothersMaidenname'],
                    'street'                => $response['street'],
                    'city'                  => $response['city'],
                    'state'                 => $response['state'],
                    'country'               => $response['country'],
                    'postcode'              => $response['postcode'],
                    'nationality'           => $response['nationality'],
                    'stateOfOrigin'         => $response['stateOfOrigin'],
                    'lgaOfOrigin'           => $response['lgaOfOrigin'],
                    'chn'                   => $response['chn'],
                    'nextOfKinName'         => $response['nextOfKinName'],
                    'nextOfKinRelationship' => $response['nextOfKinRelationship'],
                    'nextOfKinAddress'      => $response['nextOfKinAddress'],
                    'nextOfKinPhone'        => $response['nextOfKinPhone'],
                    'nextOfKinCHN'          => $response['nextOfKinCHN'],
                    'bank'                  => $response['bank'],
                    'bankAccountName'       => $response['bankAccountName'],
                    'bankAccountNumber'     => $response['bankAccountNumber'],
                    'dateAccountOpened'     => $response['dateAccountOpened'],
                    'bvn'                   => $response['bvn'],
                    'currency'              => $response['currency'],
                    'kycTier'               => $response['kycTier'],
                ]);
            }
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function KycAccStatus(Request $request)
    {
        $fields = $request->validate([
            'exchange'  => 'required|string',
            'kycRefNo'  => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "kycRefNo"             => $fields['kycRefNo'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/kyc_accountstatus',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MakeOrder(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
            'side'          => ['required', 'string', Rule::in(["BUY", "SELL"]),],
            'symbol'        => 'required|string',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric',
            'orderType'     => ['required', 'string', Rule::in(['LIMIT', 'MARKET']),],
            'duration'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo'],
            "side"                  => $fields['side'],
            "symbol"                => $fields['symbol'],
            "quantity"              => $fields['quantity'],
            "price"                 => $fields['price'],
            "orderType"             => $fields['orderType'],
            "duration"              => $fields['duration'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/oems_makeorder',
            $payload
        );

        if ($response->successful()) {
            if ($response['errors'] == []) {
                auth()->user()->investments()->create([
                    'broker' => 'naya-capitals',
                ]);
            }

            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CancelOrder(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
            'orderNo'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"              => $fields['accNo'],
            "orderNo"              => $fields['orderNo'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/oems_cancelorder',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ModifyOrder(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
            'orderNo'       => 'required|string',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric',
            'orderType'     => ['required', 'string', Rule::in(['LIMIT', 'MARKET']),],
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo'],
            "orderNo"               => $fields['orderNo'],
            "price"                 => $fields['price'],
            "orderType"             => $fields['orderType'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/oems_modifyorder',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function OrderHistory(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
            'status'        => 'string',
            'startD'        => 'required|date',
            'stopD'         => 'required|date',
            'side'          => ['required', 'string', Rule::in(['BUY', 'SELL']),],
            'pageIndex'     => 'required|integer',
            'pageSize'      => 'required|integer|max:100',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo'],
            "status"                => $fields['status'],
            "startD"                => $fields['startD'],
            "stopD"                 => $fields['stopD'],
            "side"                  => $fields['side'],
            "pageIndex"             => $fields['pageIndex'],
            "pageSize"              => $fields['pageSize'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/oems_orders',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TransactionHistory(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
            'startD'        => 'required|date',
            'stopD'         => 'required|date',
            'side'          => ['required', 'string', Rule::in(['BUY', 'SELL']),],
            'symbol'         => 'nullable|string',
            'pageIndex'     => 'required|integer',
            'pageSize'      => 'required|integer|max:100',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo'],
            "startD"                => $fields['startD'],
            "stopD"                 => $fields['stopD'],
            "side"                  => $fields['side'],
            "symbol"                => $fields['symbol'],
            "pageIndex"             => $fields['pageIndex'],
            "pageSize"              => $fields['pageSize'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/oems_contractnotes',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AssetPosition(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo']
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/pm_portfolio',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function VerifyAccountNumber(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'accNo'         => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "accNo"                 => $fields['accNo']
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/pm_verify',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CurrentMarketData(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange']
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md1_marketsnapshot',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SpecificMarketData(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'symbol'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "symbol"              => $fields['symbol']
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md1_symbolsnapshot',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MarketMovers(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md1_marketmovers',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MarketNews(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md1_news',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MarketPrices(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md1_pricelist',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MarketQuotes(Request $request)
    {
        $fields = $request->validate([
            'exchange'      => 'required|string',
            'symbol'      => 'required|string',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "exchange"              => $fields['exchange'],
            "symbol"              => $fields['symbol'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/md2_symbolquotes',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function EarningsHistory(Request $request)
    {
        $fields = $request->validate([
            'startD'        => 'required|date',
            'stopD'         => 'required|date',
            'pageIndex'     => 'required|integer',
            'pageSize'      => 'required|integer|max:100',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "startD"                => $fields['startD'],
            "stopD"                 => $fields['stopD'],
            "pageIndex"             => $fields['pageIndex'],
            "pageSize"              => $fields['pageSize'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/ag_earnings',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AgencyTradingAccounts(Request $request)
    {
        $fields = $request->validate([
            'startD'        => 'required|date',
            'stopD'         => 'required|date',
            'pageIndex'     => 'required|integer',
            'pageSize'      => 'required|integer|max:100',
        ]);
        $payload = [
            "ncpId"                 => config('services.naya.ncpid'),
            "startD"                => $fields['startD'],
            "stopD"                 => $fields['stopD'],
            "pageIndex"             => $fields['pageIndex'],
            "pageSize"              => $fields['pageSize'],
        ];


        $response = Http::withHeaders([
            'Accept' => 'multipart/form-data',
            'Content-type' => 'multipart/form-data'
        ])->post(
            config('services.naya.base_url') . '/sbconnect.svc/ag_accounts',
            $payload
        );

        if ($response->successful()) {
            return response()->json(
                [
                    json_decode($response),
                ],
                200
            );
        } elseif ($response->serverError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'server error',
                ],
                500
            );
        } elseif ($response->clientError()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'client error',
                ],
                400
            );
        } elseif ($response->failed()) {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'failed',
                ],
                401
            );
        }
    }
}
