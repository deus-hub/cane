<?php

namespace App\Http\Controllers;

use App\Models\DippReaction;
use Illuminate\Http\Request;

class DippReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = DippReaction::all();

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
