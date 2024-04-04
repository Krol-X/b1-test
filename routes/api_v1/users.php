<?php

use App\Http\Controllers\Resources\UserInfoController;

Route::prefix('users')->group(function () {
  Route::get('/', [UserInfoController::class, 'list']);
  Route::delete('/{id}', [UserInfoController::class, 'delete']);
});
