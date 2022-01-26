<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PensionFundAdminController;
use App\Http\Controllers\YoaPensionController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/resend/{id}', [UserController::class, 'resendOTP']);
    Route::post('/verify_email', [UserController::class, 'VerifyEmail']);
    Route::post('/send-reset-token', [UserController::class, 'SendResetToken']);
    Route::post('/reset-password', [UserController::class, 'ResetPassword']);
});

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // PROFILE ROUTES
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/update-profile', [UserController::class, 'UpdateProfile']);
    Route::post('/change-password', [UserController::class, 'ChangePassword']);
});

Route::prefix('bank')->middleware('auth:sanctum')->group(function () {
    // BANK CRUD
    Route::get('/all', [BankController::class, 'index']);
    Route::post('/add', [BankController::class, 'store']);
    Route::get('/{id}', [BankController::class, 'edit']);
    Route::post('/update', [BankController::class, 'update']);
    Route::get('/delete/{id}', [BankController::class, 'destroy']);
});

Route::prefix('pfa')->middleware('auth:sanctum')->group(function () {
    // PFA CRUD
    Route::get('/all', [PensionFundAdminController::class, 'index']);
    Route::post('/add', [PensionFundAdminController::class, 'store']);
    Route::get('/{id}', [PensionFundAdminController::class, 'edit']);
    Route::post('/update', [PensionFundAdminController::class, 'update']);
    Route::get('/delete/{id}', [PensionFundAdminController::class, 'destroy']);
});

Route::prefix('yoa')->middleware('auth:sanctum')->group(function () {
    // PFA CRUD
    Route::get('/get-active-products', [YoaPensionController::class, 'index']);
    Route::post('/quote/all-risk', [YoaPensionController::class, 'AllRiskQuote']);
    Route::post('/quote/motor-insurance', [YoaPensionController::class, 'MotorInsurance']);
    Route::post('/quote/home-owners-and-household-insurance', [YoaPensionController::class, 'GroupHomeOwnersInsurance']);
    Route::post('/quote/home-owners-insurance', [YoaPensionController::class, 'HomeOwnersInsurance']);
    Route::post('/quote/pay-quote', [YoaPensionController::class, 'PayQuote']);
});
