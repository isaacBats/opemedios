<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UploadPdfController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'with_fast_api_key'
], function () {
    Route::post('/upload-pdf', [UploadPdfController::class, 'upload']);
});

// Admin API routes (require auth)
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
], function () {
    Route::get('/rates/lookup', [\App\Http\Controllers\RateController::class, 'lookup'])
        ->name('api.rates.lookup');
});
