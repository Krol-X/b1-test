<?php

use App\Http\Controllers\Resources\DepartmentController;
use App\Http\Controllers\Resources\UserInfoController;
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
  Route::name('departments')->group(base_path('routes/api_v1/departments.php'));
  Route::name('users')->group(base_path('routes/api_v1/users.php'));
  Route::name('files')->group(base_path('routes/api_v1/files.php'));
  Route::name('export')->group(base_path('routes/api_v1/export.php'));
});
