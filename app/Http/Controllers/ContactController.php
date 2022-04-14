<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function SendMail(Request $request)
    {
        //create a new user
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'message' => 'required',
        ]);

        $contactMailBox = "inquiries@cane.com";

        Mail::to($contactMailBox)->send(new ContactMail($fields));

        if (count(Mail::failures()) > 0) {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to send mail'],
                500
            );
        }

        return response()->json(
            ['status' => 'true', 'message' => 'mail sent successfully'],
            200
        );
    }
}
