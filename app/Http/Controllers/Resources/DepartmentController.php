<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\DepartmentData;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

  // get /export/departments
  public function export(Request $request): StreamedResponse {
    $records = DepartmentService::listDepartments();
    $file_name = 'departments.csv';
    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
    ];
    $callback = function () use ($records) {
      $prefix = 'OU';
      $handle = fopen('php://output', 'w');
      fputcsv($handle, ['XML_ID', 'PARENT_XML_ID', 'NAME_DEPARTMENT'], ';');
      foreach ($records as $record) {
        fputcsv($handle, [$prefix . $record->id, $record->parent_id ?? '', $record->name], ';');
      }
      fclose($handle);
    };
    return response()->stream($callback, 200, $headers);
  }
}