<?php

namespace App\Services;

use App\DTO\Resources\DepartmentData;
use App\DTO\Resources\UserInfoData;
use App\Http\Controllers\Resources\DepartmentController;
use App\Http\Controllers\Resources\UserInfoController;
use App\Utils\ControllerUtils;
use Illuminate\Support\Facades\Log;

class ImportService {
  static function check_header_map(array $header, array $map) {
    $xml_columns = array_values($map);
    if (count($header) != count($xml_columns)) {
      return false;
    }
    for ($i = 0; $i < count($header); $i++) {
      if ($header[$i] !== $xml_columns[$i]) {
        return false;
      }
    }
    return true;
  }

  static function check_header(array $header, array $maps) {
    foreach ($maps as $map) {
      if (self::check_header_map($header, $map))
        return $map;
    }
    return null;
  }

  static function import($file_record, $last_department_id): bool {
    $csv = FilesService::getCsv($file_record);
    if (!$csv) {
      return false;
    }
    $header = array_shift($csv);

    $maps = [
      DepartmentController::FIELDS_MAP,
      UserInfoController::FIELDS_MAP
    ];
    Log::warning("$file_record->name");

    $records_map = self::check_header($header, $maps);
    switch ($records_map) {
      case DepartmentController::FIELDS_MAP:
        foreach ($csv as $csv_record) {
          if (count($csv_record) === 0 || !$csv_record[0])
            continue;
          Log::warning(implode(", ", $csv_record));
          $fields = ControllerUtils::remap_fields($csv_record, $records_map, true);
          $converted_parent_id = ControllerUtils::convertId(
            $fields['parent_id'], DepartmentController::PREFIX, true
          );
          if ($converted_parent_id) {
            $fields['parent_id'] = $last_department_id + $converted_parent_id;
          } else {
            $fields['parent_id'] = null;
          }
          $record_data = new DepartmentData($fields);
          DepartmentService::createDepartment($record_data);
        }
        return true;
      case UserInfoController::FIELDS_MAP:
        foreach ($csv as $csv_record) {
          if (count($csv_record) === 0 || !$csv_record[0])
            continue;
          Log::warning(implode(", ", $csv_record));
          $fields = ControllerUtils::remap_fields($csv_record, $records_map, true);
          $converted_department_id = ControllerUtils::convertId(
            $fields['department_id'], DepartmentController::PREFIX, true
          );
          if ($converted_department_id) {
            $fields['department_id'] = $last_department_id + $converted_department_id;
          } else {
            $fields['department_id'] = null;
          }
          $record_data = new UserInfoData($fields);
          UserInfoService::createUserInfo($record_data);
        }
        return true;
    }
    return false;
  }
}
