<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// web route
Route::get('/', function () {
    return view('welcome');
});



