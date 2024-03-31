<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    Sanctum::ignoreMigrations();
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    DB::listen(function ($query) {
      Log::channel('db')->info($query->sql, [
        'Bindings' => $query->bindings,
        'Time' => $query->time,
      ]);
    });
  }
}
