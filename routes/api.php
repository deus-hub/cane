<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::prefix('auth')->post('/register', function (Request $request) {
//     return 'working';
// });
Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'store'])->name('register');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/resend/{id}', [UserController::class, 'resendOTP'])->name('resend-otp');
    Route::post('/verify_email', [UserController::class, 'VerifyEmail'])->name('verify_email');
    Route::post('/send-reset-token', [UserController::class, 'SendResetToken'])->name('request_password_reset');
    Route::post('/reset-password', [UserController::class, 'ResetPassword'])->name('reset_password');
});
// Route::middleware('auth:api')->prefix('auth')->group(function ($router) {
// Route::prefix('auth')->group(['middleware' => ['auth:sanctum']], function () {
//     Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// });

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // PROFILE ROUTES
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [UserController::class, 'UpdateProfile'])->name('update_profile');
    Route::post('/change-password', [UserController::class, 'ChangePassword'])->name('change_password');
});

Route::middleware('auth:sanctum')->group(function () {
    // ACCOUNT OPENING FORM
    Route::post('/accounts/open', [AccountController::class, 'ProductsAccount'])->name('account_opening_form');
    Route::get('/accounts/open', [AccountController::class, 'ProductsAccountDetails'])->name('get_account_opening_form');
});
