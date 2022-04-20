<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TotalInvestment()
    {
        $userID = auth()->user()->id;
        $response = Investment::where('user_id', $userID)->count();
        return response()->json(
            [
                'status' => 'true',
                'total_investment' => $response
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TotalPersonalFinance()
    {
        return response()->json(
            [
                'status' => 'true',
                'total_finance' => 0
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TotalLoans()
    {
        return response()->json(
            [
                'status' => 'true',
                'total_loans' => 0
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TotalPortfolio()
    {
        $userID = auth()->user()->id;
        $totalInvestment = Investment::where('user_id', $userID)->count();

        return response()->json(
            [
                'status' => 'true',
                'total_portfolio' => $totalInvestment
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Crypto()
    {
        return Cache::remember('CryptoData', now()->addDay(), function () {
            return response()->json(
                [
                    'status' => 'true',
                    'Response' => Http::get('https://betconix.com/api/v1/all')->json(),
                ],
                200
            );
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CurrencyPairs()
    {

        return Cache::remember('CurrencyPairs', now()->addDay(), function () {
            return response()->json(
                [
                    'status' => 'true',
                    'Response' => Http::get('https://api.polygon.io/v2/aggs/grouped/locale/global/market/fx/2020-10-14?adjusted=true&apiKey=PBDLxN_aCH2W4pAFfaT0chyabOoF_Vmc')->json(),
                ],
                200
            );
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BusinessNews()
    {
        //get business news

        return Cache::remember('BusinessNews', now()->addDay(), function () {
            return response()->json(
                [
                    'status' => 'true',
                    'Response' => Http::get('https://newsapi.org/v2/everything?q=business&apiKey=390b5d1178b94e41bcb323b6ab21d84f')->json(),
                ],
                200
            );
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function IndicesFutures()
    {
        //get indices and futures

        return Cache::remember('IndicesFutures', now()->addDay(), function () {
            return response()->json(
                [
                    'status' => 'true',
                    'Response' => Http::get('https://api.polygon.io/v2/aggs/grouped/locale/us/market/stocks/2020-10-14?adjusted=true&apiKey=PBDLxN_aCH2W4pAFfaT0chyabOoF_Vmc')->json(),
                ],
                200
            );
        });

        // $response = Http::get('https://api.polygon.io/v2/aggs/grouped/locale/us/market/stocks/2020-10-14?adjusted=true&apiKey=PBDLxN_aCH2W4pAFfaT0chyabOoF_Vmc')
        //     ->json();

        // return response()->json(
        //     [
        //         'status' => 'true',
        //         'Response' => $response,
        //     ],
        //     200
        // );
    }
}
