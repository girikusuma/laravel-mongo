<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/kendaraan', [KendaraanController::class, 'index'])->middleware('jwt.verify');
Route::post('/kendaraan', [KendaraanController::class, 'store'])->middleware('jwt.verify');
Route::get('/kendaraan/{kendaraan}', [KendaraanController::class, 'show'])->middleware('jwt.verify');
Route::get('/kendaraan/{kendaraan}/edit', [KendaraanController::class, 'update'])->middleware('jwt.verify');
