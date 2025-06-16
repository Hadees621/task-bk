<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

Route::middleware('api')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/leads', [LeadController::class, 'store']);
});
