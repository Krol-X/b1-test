<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\UserInfoData;
use App\Services\UserInfoService;
use App\Utils\ControllerUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserInfoController extends ResourceController {
  const PREFIX = 'CN';

  const VALIDATION = [
    'department_id' => 'nullable|integer',
    'last_name' => 'required|string',
    'name' => 'required|string',
    'second_name' => 'required|string',
    'work_position' => 'required|string',
    'email' => 'required|string',
    'mobile_phone' => 'required|string',
    'phone' => 'required|string',
    'login' => 'required|string',
    'password' => 'required|string',
  ];

  const FIELDS_MAP = [
    'id' => 'XML_ID',
    'last_name' => 'LAST_NAME',
    'name' => 'NAME',
    'second_name' => 'SECOND_NAME',
    'department_id' => 'DEPARTMENT',
    'work_position' => 'WORK_POSITION',
    'email' => 'EMAIL',
    'mobile_phone' => 'MOBILE_PHONE',
    'phone' => 'PHONE',
    'login' => 'LOGIN',
    'password' => 'PASSWORD',
  ];

  // post /user-info
  function create(Request $request): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new UserInfoData($validated);
    $record = UserInfoService::createUserInfo($info);
    $record_formatted = ControllerUtils::remap_fields($record, self::FIELDS_MAP);

    return response()->json(
      [
        'message' => 'UserInfo created successfully',
        'data' => $record_formatted
      ],
      Response::HTTP_CREATED
    );
  }

  // get /user-info
  function list(Request $request): JsonResponse {
    $records = UserInfoService::listUserInfos();
    $records_formatted = $records->map(function ($record) {
      return ControllerUtils::remap_fields($record, self::FIELDS_MAP);
    });

    return response()->json([
      'message' => 'Ok',
      'data' => $records_formatted
    ]);
  }

  // get /user-info/{id}
  function read(Request $request, $id): JsonResponse {
    $record = UserInfoService::getUserInfo($id);

    if ($record) {
      $record_formatted = ControllerUtils::remap_fields($record, self::FIELDS_MAP);
      return response()->json([
        'message' => 'UserInfo found',
        'data' => $record_formatted,
      ]);
    } else {
      return response()->json(
        ['message' => 'UserInfo not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  // put /user-info/{id}
  function update(Request $request, $id): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new UserInfoData($validated);
    $record = UserInfoService::getUserInfo($id);

    if ($record) {
      $record_updated = UserInfoService::updateUserInfo($record, $info);
      $record_formatted = ControllerUtils::remap_fields($record_updated, self::FIELDS_MAP);
      return response()->json([
        'message' => 'UserInfo updated',
        'data' => $record_formatted
      ]);
    } else {
      return response()->json(
        ['message' => 'UserInfo not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  // delete /user-info/{id}
  function delete(Request $request, $id): JsonResponse {
    $record = UserInfoService::getUserInfo($id);

    if ($record) {
      UserInfoService::deleteUserInfo($record);
      return response()->json([
        'message' => 'UserInfo deleted',
        'id' => $id,
      ]);
    } else {
      return response()->json(
        ['message' => 'UserInfo not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  // get /export/users
  public function export(Request $request): StreamedResponse {
    $records = UserInfoService::listUserInfos();
    $file_name = 'users.csv';
    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
    ];
    $callback = function () use ($records) {
      $handle = fopen('php://output', 'w');

      fputcsv($handle, array_values(self::FIELDS_MAP), ';');
      foreach ($records as $record) {
        fputcsv($handle, [
          ControllerUtils::convertId($record->id, self::PREFIX),
          $record->last_name, $record->name, $record->second_name,
          ControllerUtils::convertId($record->department_id, DepartmentController::PREFIX),
          $record->work_position,
          $record->email, $record->mobile_phone, $record->phone,
          $record->login, $record->password
        ], ';');
      }
      fclose($handle);
    };
    return response()->stream($callback, 200, $headers);
  }
}
