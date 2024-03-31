<?php

use App\Http\Controllers\Resources\DepartmentController;

Route::prefix('department')->group(function () {
  Route::post('/', [DepartmentController::class, 'create']);
  Route::get('/', [DepartmentController::class, 'list']);
  Route::get('/{id}', [DepartmentController::class, 'read']);
  Route::put('/{id}', [DepartmentController::class, 'update']);
  Route::delete('/{id}', [DepartmentController::class, 'delete']);
});
