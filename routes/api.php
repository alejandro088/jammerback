<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\GenreController;

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

Route::group(['middleware' => 'api'], function () {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('users',[UserController::class,'get_all']);
    Route::post('users/create', [AuthController::class,'store']);
    Route::get('users/me', [AuthController::class,'me']);
    Route::get('users/{id}', [UserController::class,'get_user']);
    Route::post('users/profile', [UserController::class,'complete_profile']);
    Route::post('users/match', [MatchController::class,'match']);
    Route::post('users/accept', [MatchController::class,'accept']);
    Route::get('users/next', [MatchController::class,'next_user_randomize']);
    Route::get('users/next_preference', [MatchController::class,'next_user_preference']);
    Route::get('instruments', [InstrumentController::class,'get']);
    Route::post('instruments/create', [InstrumentController::class,'store']);
    Route::get('genres', [GenreController::class,'get']);
    Route::post('genres/create', [GenreController::class,'store']);
});
