<?php

namespace App\Utils;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DbUtils {
  static function getNextId($table_name) {
    DB::statement("ANALYZE TABLE `$table_name`");
    $table_status = DB::select('SHOW TABLE STATUS WHERE Name = ?', [$table_name]);
    $next_id = $table_status[0]->Auto_increment;
    return $next_id;
  }
}