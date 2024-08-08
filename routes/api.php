<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\EmployeeApiController;
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

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('employees', [EmployeeApiController::class, 'store']);
    Route::get('employees', [EmployeeApiController::class, 'index']);
    Route::delete('employees/{employee}/delete', [EmployeeApiController::class, 'destory']);
    Route::post('employees/{employee}/update', [EmployeeApiController::class, 'edit']);
});
