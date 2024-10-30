<?php

use App\Http\Controllers\ZohoController;
use App\Http\Middleware\CheckZohoToken;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckZohoToken::class])->group(function () {
    Route::controller(ZohoController::class)->group(function () {
        Route::get('/deals', 'deals')->name('zoho.deals');
        Route::post('/create', 'create')->name('zoho.create');
    });

    Route::get('/{any}', function () {
        return view('app');
    })->where("any", ".*");
});
