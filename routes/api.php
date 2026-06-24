<?php

use App\Http\Controllers\Api\TrackingController;
use Illuminate\Support\Facades\Route;

Route::prefix('track')->group(function () {
    Route::post('identify', [TrackingController::class, 'identify']);
    Route::post('pageview', [TrackingController::class, 'pageview']);
    Route::post('heartbeat', [TrackingController::class, 'heartbeat']);
    Route::post('contact', [TrackingController::class, 'identifyContact']);
});
