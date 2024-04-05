<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\DTO\Resources\DepartmentData;
use App\Services\DepartmentService;
use App\Utils\ControllerUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DepartmentController extends ResourceController {
  const PREFIX = 'OU';

  const VALIDATION = [
    'name' => 'required|string',
    'parent_id' => 'nullable|integer',
  ];

  const FIELDS_MAP = [
    'id' => 'XML_ID',
    'parent_id' => 'PARENT_XML_ID',
    'name' => 'NAME_DEPARTMENT'
  ];

  // post /department
  function create(Request $request): JsonResponse {
    $validated = $request->validate(self::VALIDATION);

    $info = new DepartmentData($validated);
    $record = DepartmentService::createDepartment($info);
    $record_formatted = ControllerUtils::remap_fields($record, self::FIELDS_MAP);

    return response()->json(
      [
        'message' => 'Department created successfully',
        'data' => $record_formatted
      ],
      Response::HTTP_CREATED
    );
  }

  // get /department
  function list(Request $request): JsonResponse {
    $records = DepartmentService::listDepartments();
    $records_formatted = $records->map(function ($record) {
      return ControllerUtils::remap_fields($record, self::FIELDS_MAP);
    });

    return response()->json([
      'message' => 'Ok',
      'data' => $records_formatted
    ]);
  }

  // get /department/{id}
  function read(Request $request, $id): JsonResponse {
    $record = DepartmentService::getDepartment($id);

    if ($record) {
      $record_formatted = ControllerUtils::remap_fields($record, self::FIELDS_MAP);
      return response()->json([
        'message' => 'Department found',
        'data' => $record_formatted,
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
      $record_formatted = ControllerUtils::remap_fields($record_updated, self::FIELDS_MAP);
      return response()->json([
        'message' => 'Department updated',
        'data' => $record_formatted
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
      $handle = fopen('php://output', 'w');

      fputcsv($handle, array_values(self::FIELDS_MAP), ';');
      foreach ($records as $record) {
        fputcsv($handle, [
          ControllerUtils::convertId($record->id, self::PREFIX),
          $record->parent_id ?? '', $record->name
        ], ';');
      }
      fclose($handle);
    };
    return response()->stream($callback, 200, $headers);
  }
}