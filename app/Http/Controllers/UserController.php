<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetOTP;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        //get the authenticated user
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'status' => 'true',
                'user' => $user
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'user not found'],
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
    public function UpdateProfile(Request $request)
    {
        //create a new user
        $fields = $request->validate([
            'firstname'             => 'required|string',
            'lastname'              => 'required|string',
            'phone'                 => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'BVN'                   => 'required|numeric',
            'bank'                  => 'required|string',
            'account_number'        => 'required|numeric',
            'pension_program'       => 'required|string'
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(
                ['status' => 'false', 'message' => 'user not found'],
                404
            );
        }

        $query = $user->update([
            'firstname'         => $fields['firstname'],
            'lastname'          => $fields['lastname'],
            'phone'             => $fields['phone'],
            'BVN'               => $fields['BVN'],
            'account_number'    => $fields['account_number'],
            'pension_program'   => $fields['pension_program']
        ]);


        if ($query) {
            return response()->json([
                'status' => 'true',
                'message' => 'user profile updated successfully'
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'profile update failed'],
                200
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SendResetToken(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response()->json(
                ['status' => 'false', 'message' => 'user not found'],
                404
            );
        }

        if (!empty($user->otp)) {
            $otp = $user->otp;
        } else {
            $otp = random_int(100000, 999999);

            $user->update([
                'otp' => $otp
            ]);
        }

        Mail::to($user->email)->send(new PasswordResetOTP($otp));

        if (!count(Mail::failures())) {
            return response()->json([
                'status' => 'true',
                'message' => "otp sent to $user->email ",
                'otp' => $otp
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to send mail'],
                200
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //create a new user
        auth()->user()->tokens()->delete();

        return response()->json(
            ['status' => 'true', 'message' => 'user has been logged out successfully'],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a new user
        $fields = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'password' => 'required|string|confirmed|min:6',
            'confirm_checkbox' => 'required'
        ]);

        $password = bcrypt($fields['password']);
        $otp = random_int(100000, 999999);

        Mail::to($fields['email'])->send(new VerifyEmail($otp));

        if (count(Mail::failures()) > 0) {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to send mail'],
                200
            );
        }

        $user = User::create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'password' => $password,
            'otp' => $otp
        ]);

        $userEmail = $fields['email'];

        if ($user) {
            return response()->json([
                'status' => 'true',
                'message' => "otp sent to $userEmail ",
                'user' => $user
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'account not created'],
                200
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChangePassword(Request $request)
    {
        //create a new user
        $fields = $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $new_password = bcrypt($fields['password']);
        $old_password = $fields['old_password'];

        $user = auth()->user();

        $verify_old_password = Hash::check($old_password, $user->password);

        if ($verify_old_password) {
            $user->update([
                'password' => $new_password
            ]);

            return response()->json(
                ['status' => 'true', 'message' => 'user password changed successfully'],
                200
            );
        } else {
            return response()->json(
                ['status' => 'false', 'message' => 'passwords do not match'],
                200
            );
        }
        return response()->json(
            ['status' => 'false', 'message' => 'password change failed'],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //create a new user
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // check email
        $user = User::where('email', $fields['email'])->first();

        // check if user exists
        if (!$user) {
            return response()->json(
                ['status' => 'false', 'message' => 'user does not exist'],
                200
            );
        }

        // check if user exists
        if (!empty($user->otp)) {
            return response()->json([
                'status' => 'false',
                'message' => 'mail not verified',
                'user' => $user->id
            ], 200);
        }

        // check if passwor provided matches the on in the database
        if (!Hash::check($fields['password'], $user->password)) {
            return response()->json(
                ['status' => 'false', 'message' => 'incorrect password'],
                200
            );
        }

        // create a personal access token for the user
        $token = $user->createToken('myapptoken')->plainTextToken;

        if ($token) {
            return response()->json([
                'status' => 'true',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json(
                ['status' => 'false', 'message' => ' login unsucessful'],
                200
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resendOTP($id)
    {

        // get orders from orders table where search parameter exists in the product column

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['status' => 'false', 'error' => 'user does not exist'], 404);
        }

        $otp = $user->otp;
        Mail::to($user->email)->send(new VerifyEmail($otp));

        if (count(Mail::failures()) > 0) {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to send mail'],
                200
            );
        } else {
            return response()->json([
                'status' => 'true',
                'message' => "otp sent to $user->email ",
                'user' => $user
            ], 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function VerifyEmail(Request $request)
    {
        $fields = $request->validate([
            'otp' => 'required|integer|numeric|digits:6'
        ]);

        $user = User::where('otp', $fields['otp'])->first();

        if (!$user) {
            return response()->json(['status' => 'false', 'error' => 'invalid otp'], 404);
        }

        // $otp = $user->otp;

        $query = $user->update([
            'otp' => ''
        ]);

        if (!$query) {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to verify email'],
                200
            );
        } else {
            return response()->json([
                'status' => 'true',
                'message' => "email verified successfully"
            ], 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ResetPassword(Request $request)
    {
        $fields = $request->validate([
            'otp' => 'required|integer|numeric|digits:6',
            'password' => 'required|string|confirmed'
        ]);

        // return $fields['otp'];

        $user = User::where('otp', $fields['otp'])->first();

        if (!$user) {
            return response()->json(['status' => 'false', 'error' => 'invalid otp'], 404);
        }

        $newPassword = bcrypt($fields['password']);

        $query = $user->update([
            'otp' => '',
            'password' => $newPassword
        ]);

        if (!$query) {
            return response()->json(
                ['status' => 'false', 'message' => 'unable to reset password'],
                200
            );
        } else {
            return response()->json([
                'status' => 'true',
                'message' => "password reset was successful"
            ], 200);
        }
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
