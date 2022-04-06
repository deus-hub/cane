<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return response()->json(
            [
                'status' => 'true',
                'total_investment' => 0
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
        return response()->json(
            [
                'status' => 'true',
                'total_portfolio' => 0
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
        //get active products
        $response = Http::get('https://betconix.com/api/v1/all')
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'Response' => $response,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CurrencyPairs()
    {
        //get active products
        $response = Http::get('https://api.polygon.io/v2/aggs/grouped/locale/global/market/fx/2020-10-14?adjusted=true&apiKey=PBDLxN_aCH2W4pAFfaT0chyabOoF_Vmc')
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'Response' => $response,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BusinessNews()
    {
        //get active products
        $response = Http::get('https://newsapi.org/v2/everything?q=business&apiKey=390b5d1178b94e41bcb323b6ab21d84f')
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'Response' => $response,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function IndicesFutures()
    {
        //get active products
        $response = Http::get('https://api.polygon.io/v2/aggs/grouped/locale/us/market/stocks/2020-10-14?adjusted=true&apiKey=PBDLxN_aCH2W4pAFfaT0chyabOoF_Vmc')
            ->json();

        return response()->json(
            [
                'status' => 'true',
                'Response' => $response,
            ],
            200
        );
    }
}
