<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index']);
});
