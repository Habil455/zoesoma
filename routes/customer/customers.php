<?php

use App\Http\Controllers\Customers\CustomerProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(CustomerProfileController::class)->group(function () {

Route::get('/dashboard', 'dashboard')->name('customer.dashboard');

});

