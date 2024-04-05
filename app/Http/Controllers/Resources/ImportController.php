<?php


namespace App\Http\Controllers\Resources;

use App\Services\DepartmentService;
use App\Services\FilesService;
use App\Services\ImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ImportController extends BaseController {
  function import(Request $request): JsonResponse {
    $files = FilesService::listFiles();
    $last_department_id = DepartmentService::getNextId() - 1;
    $files->each(function ($file_record) use ($last_department_id) {
      if (ImportService::import($file_record, $last_department_id)) {
        // FilesService::deleteFile($file_record);
      }
    });
    return response()->json([
      'message' => 'Ok'
    ]);
  }
}
