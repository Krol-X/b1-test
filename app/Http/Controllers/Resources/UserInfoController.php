<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\UserInfoData;
use App\Services\UserInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserInfoController extends ResourceController {
  const VALIDATION = [
    'department_id' => 'nullable|integer',
    'last_name' => 'required|string',
    'name' => 'required|string',
    'second_name' => 'required|string',
    'work_position' => 'required|string',
    'mobile_phone' => 'required|string',
    'phone' => 'required|string',
    'login' => 'required|string',
    'password' => 'required|string',
  ];

  // post /user-info
  function create(Request $request): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new UserInfoData($validated);
    $record = UserInfoService::createUserInfo($info);

    return response()->json(
      [
        'message' => 'UserInfo created successfully',
        'data' => $record
      ],
      Response::HTTP_CREATED
    );
  }

  // get /user-info
  function list(Request $request): JsonResponse {
    $records = UserInfoService::listUserInfos();

    return response()->json([
      'message' => 'Ok',
      'data' => $records
    ]);
  }

  // get /user-info/{id}
  function read(Request $request, $id): JsonResponse {
    $record = UserInfoService::getUserInfo($id);

    if ($record) {
      return response()->json([
        'message' => 'UserInfo found',
        'data' => $record,
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
      return response()->json([
        'message' => 'UserInfo updated',
        'data' => $record
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
      $prefix = 'CN';
      $prefix_department = 'OU';
      $handle = fopen('php://output', 'w');
      fputcsv($handle, [
        'XML_ID', 'LAST_NAME', 'NAME', 'SECOND_NAME',
        'DEPARTMENT', 'WORK_POSITION', 'EMAIL',
        'MOBILE_PHONE', 'PHONE', 'LOGIN', 'PASSWORD'
      ], ';');
      foreach ($records as $record) {
        fputcsv($handle, [
          $prefix . $record->id, $record->last_name, $record->name, $record->second_name,
          $prefix_department . $record->department_id, $record->work_position, $record->email,
          $record->mobile_phone, $record->phone, $record->login, $record->password
        ], ';');
      }
      fclose($handle);
    };
    return response()->stream($callback, 200, $headers);
  }
}
