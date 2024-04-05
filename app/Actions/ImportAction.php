<?php

namespace App\Actions;

use App\DTO\Resources\DepartmentData;
use App\DTO\Resources\UserInfoData;
use App\Http\Controllers\Resources\DepartmentController;
use App\Http\Controllers\Resources\UserInfoController;
use App\Services\DepartmentService;
use App\Services\UserInfoService;
use App\Utils\ControllerUtils;

class ImportAction {
  private $departments_data = [];
  private $user_infos_data = [];

  public function addDepartmentsData(array $data) {
    $this->departments_data[] = $data;
  }

  public function addUserInfosData(array $data) {
    $this->user_infos_data[] = $data;
  }

  public function importData($last_department_id) {
    foreach ($this->departments_data as $departments_data) {
      $this->importDepartments($departments_data, $last_department_id);
    }
    foreach ($this->user_infos_data as $user_info_data) {
      $this->importUserInfos($user_info_data, $last_department_id);
    }
  }

  private function importDepartments($csv_data, $last_department_id): void {
    foreach ($csv_data as $data) {
      if (!$data || !$data[0])
        continue;
      $fields = ControllerUtils::remap_fields($data, DepartmentController::FIELDS_MAP, true);
      $convertedParentId = ControllerUtils::convertId(
        $fields['parent_id'], DepartmentController::PREFIX, true
      );

      $fields['parent_id'] = null;
      if ($convertedParentId) {
        $parent_id = $last_department_id + $convertedParentId;
        if (DepartmentService::getDepartment($parent_id)) {
          $fields['parent_id'] = $parent_id;
        }
      }

      $recordData = new DepartmentData($fields);
      DepartmentService::createDepartment($recordData);
    }
  }

  private function importUserInfos($csv_data, $last_department_id): void {
    foreach ($csv_data as $data) {
      if (!$data || !$data[0])
        continue;
      $fields = ControllerUtils::remap_fields($data, UserInfoController::FIELDS_MAP, true);
      $convertedDepartmentId = ControllerUtils::convertId(
        $fields['department_id'], DepartmentController::PREFIX, true
      );

      $fields['department_id'] = null;
      if ($convertedDepartmentId) {
        $department_id = $last_department_id + $convertedDepartmentId;
        if (DepartmentService::getDepartment($department_id)) {
          $fields['department_id'] = $department_id;
        }
      }

      $recordData = new UserInfoData($fields);
      UserInfoService::createUserInfo($recordData);
    }
  }
}
