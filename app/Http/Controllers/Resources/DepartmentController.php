<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\DepartmentData;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends ResourceController {
  const VALIDATION = [
    'name' => 'required|string',
    'parent_id' => 'nullable|integer',
  ];

  function create(Request $request): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new DepartmentData($validated);
    $record = DepartmentService::createDepartment($info);

    return response()->json(
      [
        'message' => 'Department created',
        'id' => $record->id,
        'created_at' => $record->created_at,
      ],
      Response::HTTP_CREATED
    );
  }

  function list(Request $request): JsonResponse {
    $records = DepartmentService::listDepartments();

    return response()->json(
      [
        'message' => 'Ok',
        'data' => $records,
      ],
      Response::HTTP_OK
    );
  }

  function read(Request $request, $id): JsonResponse {
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      return response()->json(
        [
          'message' => 'Department found',
          'data' => $record,
        ],
        Response::HTTP_OK
      );
    } else {
      return response()->json(
        [
          'message' => 'Department not found',
        ],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  function update(Request $request, $id): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new DepartmentData($validated);
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      $record_updated = DepartmentService::updateDepartment($record, $info);
      return response()->json(
        [
          'message' => 'Department updated',
          'id' => $record_updated->id,
          'created_at' => $record_updated->created_at,
        ],
        Response::HTTP_OK
      );
    } else {
      return response()->json(
        [
          'message' => 'Department not found',
        ],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  function delete(Request $request, $id): JsonResponse {
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      $record->delete();
      return response()->json(
        [
          'message' => 'Department deleted',
          'id' => $id,
        ],
        Response::HTTP_OK
      );
    } else {
      return response()->json(
        [
          'message' => 'Department not found',
        ],
        Response::HTTP_NOT_FOUND
      );
    }
  }
}
