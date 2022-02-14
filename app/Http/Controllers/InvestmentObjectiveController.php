<?php

namespace App\Http\Controllers;

use App\Models\InvestmentObjective;
use Illuminate\Http\Request;

class InvestmentObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = InvestmentObjective::all();

        if ($questions) {
            return response()->json([
                'status' => 'true',
                'questions' => $questions
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'no questions found'],
                404
            );
        }
    }
}
