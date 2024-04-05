<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
  return Inertia::render('About');
});

Route::get('/user-infos', function () {
  return Inertia::render('UserInfos');
});

Route::get('/departments', function () {
  return Inertia::render('Departments');
});

Route::get('/import', function () {
  return Inertia::render('Import');
});
