<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductsAccountDetails()
    {
        //get the authenticated user
        $user_details = auth()->user();

        if ($user_details) {
            return response()->json([
                'status' => 'true',
                'user-details' => [
                    'firstname' => $user_details->firstname,
                    'lastname' => $user_details->lastname,
                    'email' => $user_details->email,
                    'phone' => $user_details->phone
                ]
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'user details not found'],
                404
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductsAccount(Request $request)
    {
        //validate Post data
        $fields = $request->validate([
            'firstname'             => 'required|string',
            'lastname'              => 'required|string',
            'email'                 => 'required|string',
            'phone'                 => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'BVN'                   => 'required|numeric',
            'bank'                  => 'required|string',
            'account_number'        => 'required|numeric',
            'pension_program'       => 'required|string'
        ]);

        $user_account = auth()->user()->account()->create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'BVN' => $fields['BVN'],
            'bank' => $fields['bank'],
            'account_number' => $fields['account_number'],
            'pension_program' => $fields['pension_program'],

        ]);

        if ($user_account) {
            return response()->json([
                'status' => 'true',
                'message' => "user account stored successfully",
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'user account not created'],
                200
            );
        }
    }
}
