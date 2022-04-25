<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function InitializePaystackPayment(Request $request)
    {
        //validate request fields
        $inputFields = $request->validate([
            'email'         => 'required|email',
            'amount'       => 'required|numeric',
            'reference'     => 'required|string'
        ]);

        // $url = "https://api.paystack.co/transaction/initialize";
        // $newReference = str_replace('/', '-', $inputFields['reference']);

        // $fields = [
        //     'email'         => $inputFields['email'],
        //     'amount'        => $inputFields['amount'] * 100,
        //     'reference'     => $newReference,
        // ];

        $create_payment = auth()->user()->payments()->create([
            'email'         => $inputFields['email'],
            'amount'        => $inputFields['amount'],
            'reference'     => $inputFields['reference'],
            'status'        => 'pending',
        ]);

        // $fields_string = http_build_query($fields);
        // $secretKey = config('services.paystack.secret_key');

        //open connection
        // $ch = curl_init();

        //set the url, number of POST vars, POST data
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     "Authorization: Bearer $secretKey",
        //     "Cache-Control: no-cache",
        // ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        // $result = curl_exec($ch);

        if ($create_payment) {
            return response()->json(
                [
                    'status' => 'true',
                    'response' => 'success',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'false',
                    'response' => 'error initiating payment',
                ],
                500
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function VerifyPaystackPayment(Request $request)
    {
        if ($request->response->data->status === 'success') {
            $amount = $request->response->data->amount;
            $reference = $request->response->data->reference;

            Payment::where(['amount' => $amount, 'reference' => $reference])->update([
                'status' => 'successful',
            ]);
        } else {
            $amount = $request->response->data->amount;
            $reference = $request->response->data->reference;

            Payment::where(['amount' => $amount, 'reference' => $reference])->update([
                'status' => 'failed',
            ]);
        }

        // if ($request->has('reference')) {
        //     $reference = $request->input('reference');
        // }

        // $secretKey = config('services.paystack.secret_key');

        // $curl = curl_init();
        // curl_setopt_array($curl, array(

        //     CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "Authorization: Bearer $secretKey",
        //         "Cache-Control: no-cache",
        //     ),

        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);

        // if ($err) {
        //     return "cURL Error #:" . $err;
        // } else {
        //     return $response;
        // }
        // echo $reference;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
