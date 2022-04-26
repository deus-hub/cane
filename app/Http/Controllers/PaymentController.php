<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Create a new transaction for the user.
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

        $create_payment = auth()->user()->payments()->create([
            'email'         => $inputFields['email'],
            'amount'        => $inputFields['amount'],
            'reference'     => $inputFields['reference'],
            'status'        => 'pending',
        ]);

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
     * Update transaction status with response webhook from Paystack
     *
     * @return \Illuminate\Http\Response
     */
    public function VerifyPaystackPayment()
    {
        // if ($request->response->data->status === 'success') {
        //     $amount = $request->response->data->amount;
        //     $reference = $request->response->data->reference;

        //     Payment::where(['amount' => $amount, 'reference' => $reference])->update([
        //         'status' => 'successful',
        //     ]);
        // } else {
        //     $amount = $request->response->data->amount;
        //     $reference = $request->response->data->reference;

        //     Payment::where(['amount' => $amount, 'reference' => $reference])->update([
        //         'status' => 'failed',
        //     ]);
        // }

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('x-paystack-signature', $_SERVER))
            exit();

        // Retrieve the request's body
        $input = @file_get_contents("php://input");
        $secretKey = config('services.paystack.secret_key');

        if ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $secretKey)) {
            exit();
        }

        http_response_code(200);

        $event = json_decode($input);
        switch ($event->event) {
            case 'charge.success':
                //your logic
                Log::info($event);
                break;
        }

        exit();
    }
}
