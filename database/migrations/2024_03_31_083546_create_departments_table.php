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
    Schema::create('departments', function (Blueprint $table) {
      $table->id();
      $table
        ->foreignIdFor(Department::class, 'parent_id')
        ->nullable()
        ->constrained('departments');
      $table->string('name');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('departments');
  }
};
