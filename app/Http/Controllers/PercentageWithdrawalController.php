<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePercentageWithdrawalRequest;
use App\Http\Requests\UpdatePercentageWithdrawalRequest;
use App\Models\PercentageWithdrawal;

class PercentageWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = PercentageWithdrawal::all();

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
