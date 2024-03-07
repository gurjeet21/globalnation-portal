<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    ManageApiController
};

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
Route::get('/download-content',  [ManageApiController::class, 'downloadContent']);
Route::get('/download-test-content',  [ManageApiController::class, 'downloadTestContent']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
