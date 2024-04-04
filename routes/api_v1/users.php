<?php

use App\Http\Controllers\Resources\UserInfoController;

Route::prefix('users')->group(function () {
  Route::post('/', [UserInfoController::class, 'create']);
  Route::get('/', [UserInfoController::class, 'list']);
  Route::get('/{id}', [UserInfoController::class, 'read']);
  Route::put('/{id}', [UserInfoController::class, 'update']);
  Route::delete('/{id}', [UserInfoController::class, 'delete']);
});
