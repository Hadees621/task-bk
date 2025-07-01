<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    // Route::post('/leads', [LeadController::class, 'store']);
    // Route::get('/leads/search', [LeadController::class, 'search']);
});
