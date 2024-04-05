<?php

namespace App\Services;

use App\Actions\ImportAction;
use App\DTO\Resources\DepartmentData;
use App\DTO\Resources\UserInfoData;
use App\Http\Controllers\Resources\DepartmentController;
use App\Http\Controllers\Resources\UserInfoController;
use App\Utils\ControllerUtils;

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

  static function import($file_record, ImportAction $action): bool {
    $csv = FilesService::getCsv($file_record);
    if (!$csv) {
      return false;
    }
    $header = array_shift($csv);

    $maps = [
      DepartmentController::FIELDS_MAP,
      UserInfoController::FIELDS_MAP
    ];

    $records_map = self::check_header($header, $maps);
    switch ($records_map) {
      case DepartmentController::FIELDS_MAP:
        $action->addDepartmentsData($csv);
        return true;
      case UserInfoController::FIELDS_MAP:
        $action->addUserInfosData($csv);
        return true;
    }
    return false;
  }
}
