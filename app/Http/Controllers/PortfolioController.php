<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
