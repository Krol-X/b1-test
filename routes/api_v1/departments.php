<?php

use App\Http\Controllers\Resources\DepartmentController;

Route::prefix('departments')->group(function () {
  Route::get('/', [DepartmentController::class, 'list']);
  Route::delete('/{id}', [DepartmentController::class, 'delete']);
});
