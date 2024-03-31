<?php

namespace App\Services;

use App\DTO\Resources\DepartmentInfo;
use App\Models\Department;
use Illuminate\Support\Collection;

class DepartmentService {
  public static function createDepartment(DepartmentInfo $info): Department {
    $record = Department::create($info->toArray());
    return $record;
  }

  public static function listDepartments(callable $filter = null): Collection {
    $query = Department::query();
    if ($filter && is_callable($filter)) {
      $query = $filter($query);
    } else {
      $query = $query->orderBy('created_at', 'desc');
    }
    return $query->get();
  }

  public static function getDepartment(int $id): ?Department {
    $record = Department::find($id);
    return $record;
  }

  public static function updateDepartment(Department $record, DepartmentInfo $info): Department {
    $record->update($info->toArray());
    return $record;
  }

  public static function deleteDepartment(Department $department): void {
    $department->delete();
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
}