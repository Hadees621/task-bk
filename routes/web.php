<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/leads/test', [LeadController::class, 'index']);

// Route::get('/test-redis', function () {
//     Cache::put('foo', 'bar', 60); // stores 'bar' for 60 minutes
//     return Cache::get('foo');     // should return 'bar'
// });
