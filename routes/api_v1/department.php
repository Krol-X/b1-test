<?php

use App\Http\Controllers\Resources\DepartmentController;

Route::prefix('department')->group(function () {
  Route::get('/', [DepartmentController::class, 'list']);
  Route::delete('/{id}', [DepartmentController::class, 'delete']);
});
