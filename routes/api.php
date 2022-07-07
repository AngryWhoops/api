<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardController;

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

Route::get('/getallcards', [CardController::class, 'getallcards']);
Route::get('/getcardbyid/{id}', [CardController::class, 'getcardbyid']);
Route::post('/createcard', [CardController::class, 'createcard']);
Route::post('/deleteall', [CardController::class, 'deleteall']);
Route::post('/deleteby/{id}', [CardController::class, 'deletecardbyid']);

