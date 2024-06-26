<?php

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('user_infos', function (Blueprint $table) {
      $table->id();
      $table
        ->foreignIdFor(Department::class)
        ->nullable()
        ->constrained();
      $table->string('last_name');
      $table->string('name');
      $table->string('second_name');
      $table->string('work_position');
      $table->string('email');
      $table->string('mobile_phone');
      $table->string('phone');
      $table->string('login');
      $table->string('password');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('user_infos');
  }
};
