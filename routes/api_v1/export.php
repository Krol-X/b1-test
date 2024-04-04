<?php

use App\Http\Controllers\Resources\DepartmentController;
use App\Http\Controllers\Resources\UserInfoController;

Route::prefix('export')->group(function () {
  Route::get('departments', [DepartmentController::class, 'export']);
  Route::get('users', [UserInfoController::class, 'export']);
});
