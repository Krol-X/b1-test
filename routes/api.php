<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (backend)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::prefix('v1')->group(function () {
  Route::name('department')->group(base_path('routes/api_v1/department.php'));
  Route::name('user_info')->group(base_path('routes/api_v1/user_info.php'));
  Route::name('files')->group(base_path('routes/api_v1/files.php'));
});
