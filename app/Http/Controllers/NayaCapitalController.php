<?php

namespace App\Http\Controllers;

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

        // return $payload;

        $statesCode = Http::withHeaders([
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.naya.base_url') . '/sbconnect.svc/utils_nigerianstates',
                $payload
            );

        return response()->json(
            [
                'status' => 'true',
                'States' => json_decode($statesCode),
            ],
            200
        );
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

        $bankCodes = Http::withHeaders([
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
        ])
            ->post(
                config('services.naya.base_url') . '/sbconnect.svc/utils_nigerianbanks',
                $payload
            );

        return response()->json(
            [
                'status' => 'true',
                'Banks' => json_decode($bankCodes),
            ],
            200
        );
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
        ])
            ->post(
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
}
