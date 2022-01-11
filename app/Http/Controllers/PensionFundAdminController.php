<?php

namespace App\Http\Controllers;

use App\Models\PensionFundAdmin;
use Illuminate\Http\Request;

class PensionFundAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all pension administrators
        $pfas = PensionFundAdmin::all();

        if ($pfas) {
            return response()->json([
                'status' => 'true',
                'PFAs' => $pfas
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'PFAs not found'],
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
            'name' => 'required|string',
        ]);

        $add_pfa = PensionFundAdmin::create([
            'name' => $fields['name'],
        ]);

        if ($add_pfa) {
            return response()->json([
                'status' => 'true',
                'message' => "successful",
                'new_pfa' => $add_pfa
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'PFA not added']
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PensionFundAdmin  $pensionFundAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pfa = PensionFundAdmin::where('id', $id)->first();

        if (!$pfa) {
            return response()->json(['status' => 'false', 'error' => 'PFA not found'], 404);
        } else {
            return response()->json([
                'status' => 'true',
                'PFA' => $pfa
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PensionFundAdmin  $pensionFundAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //update an existing PFA
        $fields = $request->validate([
            'name' => 'required|string',
            'id' => 'required|numeric'
        ]);

        $pfa = PensionFundAdmin::find($fields['id']);

        if (!$pfa) {
            return response()->json(
                ['status' => 'false', 'message' => 'PFA not found']
            );
        }

        $updated_pfa = $pfa->update([
            'name' => $fields['name'],
        ]);

        if ($updated_pfa) {
            return response()->json([
                'status' => 'true',
                'message' => "successful"
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'PFA not updated']
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PensionFundAdmin  $pensionFundAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pfa = PensionFundAdmin::find($id);

        if (!$pfa) {
            return response()->json(
                ['status' => 'false', 'message' => 'bank not found']
            );
        }

        $deleted_bank = $pfa->delete();

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
