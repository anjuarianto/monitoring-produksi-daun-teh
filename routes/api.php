<?php

use App\Http\Controllers\Api\DaunController;
use App\Http\Controllers\Api\HasilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/daun', [DaunController::class, 'get'])->name('daun.data_daun_by_mandor');
Route::get('/hasil/{hasil}', [HasilController::class, 'show'])->name('api.hasil.show');
