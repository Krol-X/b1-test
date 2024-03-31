<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
  return Inertia::render('Home');
});

Route::get('/test', function () {
  return Inertia::render('Test', ['user' => 'You']);
});
