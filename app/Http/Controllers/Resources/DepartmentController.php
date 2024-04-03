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

  // post /department
  function create(Request $request): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new DepartmentData($validated);
    $record = DepartmentService::createDepartment($info);

    return response()->json(
      [
        'message' => 'Department created successfully',
        'data' => $record
      ],
      Response::HTTP_CREATED
    );
  }

  // get /department
  function list(Request $request): JsonResponse {
    $records = DepartmentService::listDepartments();

    return response()->json([
      'message' => 'Ok',
      'data' => $records
    ]);
  }

  // get /department/{id}
  function read(Request $request, $id): JsonResponse {
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      return response()->json([
        'message' => 'Department found',
        'data' => $record,
      ]);
    } else {
      return response()->json(
        ['message' => 'Department not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  // put /department/{id}
  function update(Request $request, $id): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new DepartmentData($validated);
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      $record_updated = DepartmentService::updateDepartment($record, $info);
      return response()->json([
        'message' => 'Department updated',
        'data' => $record
      ]);
    } else {
      return response()->json(
        ['message' => 'Department not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }

  // delete /department/{id}
  function delete(Request $request, $id): JsonResponse {
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      DepartmentService::deleteDepartment($record);
      return response()->json([
        'message' => 'Department deleted',
        'id' => $id,
      ]);
    } else {
      return response()->json(
        ['message' => 'Department not found'],
        Response::HTTP_NOT_FOUND
      );
    }
  }
}
