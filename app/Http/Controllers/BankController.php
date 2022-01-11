<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all banks
        $banks = Bank::all();

        if ($banks) {
            return response()->json([
                'status' => 'true',
                'banks' => $banks
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'banks not found'],
                404
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a new bank
        $fields = $request->validate([
            'bank_code' => 'required|numeric|digits:3',
            'name' => 'required|string',
        ]);

        $add_bank = Bank::create([
            'bank_code' => $fields['bank_code'],
            'bank' => $fields['name'],
        ]);

        if ($add_bank) {
            return response()->json([
                'status' => 'true',
                'message' => "successful",
                'new_bank' => $add_bank
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'bank not added']
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = Bank::where('id', $id)->first();

        if (!$bank) {
            return response()->json(['status' => 'false', 'error' => 'no bank found'], 404);
        } else {
            return response()->json([
                'status' => 'true',
                'bank' => $bank
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //update an existing bank
        $fields = $request->validate([
            'bank_code' => 'required|numeric|digits:3',
            'name' => 'required|string',
            'id' => 'required|numeric'
        ]);

        $bank = Bank::find($fields['id']);

        if (!$bank) {
            return response()->json(
                ['status' => 'false', 'message' => 'bank not found']
            );
        }

        $updated_bank = $bank->update([
            'bank_code' => $fields['bank_code'],
            'bank' => $fields['name'],
        ]);

        if ($updated_bank) {
            return response()->json([
                'status' => 'true',
                'message' => "successful"
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'bank not updated']
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json(
                ['status' => 'false', 'message' => 'bank not found']
            );
        }

        $deleted_bank = $bank->delete($bank);

        if ($deleted_bank) {
            return response()->json([
                'status' => 'true',
                'message' => "successful"
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'deletion failed']
            );
        }
    }
}
