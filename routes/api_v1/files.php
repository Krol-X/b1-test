<?php

use App\Http\Controllers\Resources\FilesController;

Route::prefix('files')->group(function () {
  Route::post('/', [FilesController::class, 'create']);
  Route::get('/', [FilesController::class, 'list']);
  Route::delete('/{id}', [FilesController::class, 'delete']);
});
