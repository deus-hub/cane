<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycInfoRequest;
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
    public function KycStatus(Request $request)
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
}
