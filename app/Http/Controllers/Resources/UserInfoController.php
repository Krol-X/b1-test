<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\UserInfoData;
use App\Services\UserInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        'data' => $record->toJson()
      ],
      Response::HTTP_CREATED
    );
  }

  // get /user-info
  function list(Request $request): JsonResponse {
    $records = UserInfoService::listUserInfos();

    return response()->json([
      'message' => 'Ok',
      'data' => $records->toJson()
    ]);
  }

  // get /user-info/{id}
  function read(Request $request, $id): JsonResponse {
    $record = UserInfoService::getUserInfo($id);

    if ($record) {
      return response()->json([
        'message' => 'UserInfo found',
        'data' => $record->toJson(),
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
        'data' => $record->toJson()
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
}
