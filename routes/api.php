<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

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

Route::get('/getallposts', [PostController::class, 'getallposts']);
Route::get('/getpostbyid/{id}', [PostController::class, 'getpostbyid']);
Route::post('/createpost', [PostController::class, 'createpost']);
Route::post('/deleteall', [PostController::class, 'deleteall']);
Route::post('/deletepostbyid/{id}', [PostController::class, 'deletepostbyid']);

