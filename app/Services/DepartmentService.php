<?php

namespace App\Services;

use App\DTO\Resources\DepartmentData;
use App\Models\Department;
use App\Utils\DbUtils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DepartmentService {
  public static function createDepartment(DepartmentData $info): Department {
    $record = Department::create($info->toArray());
    return $record;
  }

  public static function listDepartments(callable $filter = null): Collection {
    $query = Department::query();
    if ($filter && is_callable($filter)) {
      $query = $filter($query);
    }
    return $query->get();
  }

  public static function getNextId(): int {
    $next_id = DbUtils::getNextId('departments');
    return $next_id;
  }

  public static function getDepartment(int $id): ?Department {
    $record = Department::find($id);
    return $record;
  }

  public static function updateDepartment(Department $record, DepartmentData $info): Department {
    $record->update($info->toArray());
    return $record;
  }

  public static function deleteDepartment(Department $record): void {
    $record->delete();
  }

  public static function getTrashed(int $id): ?Department {
    $trashed_record = Department::withTrashed()->find($id);
    return $trashed_record;
  }

  public static function restoreDepartment(int $id): ?Department {
    $record = self::getTrashed($id);
    if ($record) {
      $record->restore();
      return $record;
    }
    return null;
  }

  public static function deleteAllDepartments() {
    DB::table('departments')->update(['parent_id' => null]);
    DB::table('user_infos')->update(['department_id' => null]);
    DB::table('departments')->delete();
    DB::statement('ALTER TABLE departments AUTO_INCREMENT = 1');
  }
}
