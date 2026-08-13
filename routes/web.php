<?php

use Illuminate\Support\Facades\Route;

// TASK-08: Dashboard entry point
// Owner: Nigel
Route::get('/', function () {
    return view('dashboard.index');
});
