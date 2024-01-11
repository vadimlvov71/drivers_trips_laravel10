<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriversPayableTimeController;
use App\Http\Controllers\DriversController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DriversPayableTimeController::class, 'index' ]);
Route::post('/uploadfile', [DriversPayableTimeController::class, 'uploadFile' ]);
Route::get('/total', [DriversPayableTimeController::class, 'getTotalMinutesWithPassenger' ]);
Route::group(['middleware' => ['cors']], function() {
    Route::get('/angular', [DriversPayableTimeController::class, 'angular' ]);
    Route::get('/angular_order/{order}', [DriversPayableTimeController::class, 'angularOrder' ]);
});