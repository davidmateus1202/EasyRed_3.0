<?php

use Illuminate\Support\Facades\Route;

/**
 * Routes for web
 */
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');