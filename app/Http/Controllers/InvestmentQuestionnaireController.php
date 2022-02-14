<?php

namespace App\Http\Controllers;

use App\Models\InvestmentQuestionnaire;
use Illuminate\Http\Request;

class InvestmentQuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'percentage_withdrawal'             => 'required|numeric',
            'investment_objective'              => 'required|numeric',
            'expected_initial_withdrawal'       => 'required|numeric',
            'investment_income_reliance'        => 'required|numeric',
            'dipp_reaction'                     => 'required|numeric'
        ]);

        $result = InvestmentQuestionnaire::where([
            ['percentage_withdrawal', '=', $fields['percentage_withdrawal']],
            ['investment_objective', '=', $fields['investment_objective']],
            ['initial_withdrawal', '=', $fields['expected_initial_withdrawal']],
            ['investment_reliance', '=', $fields['investment_income_reliance']],
            ['dipp_reaction', '=', $fields['dipp_reaction']]
        ])->first();

        if ($result) {
            return response()->json([
                'status' => 'true',
                'response' => $result->response,
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'no result'],
                200
            );
        }
    }
}
