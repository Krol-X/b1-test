<?php


namespace App\Http\Controllers\Resources;

use App\Actions\ImportAction;
use App\Services\DepartmentService;
use App\Services\FilesService;
use App\Services\ImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ImportController extends BaseController {
  function import(Request $request): JsonResponse {
    $files = FilesService::listFiles();
    $action = new ImportAction();
    $files->each(function ($file_record) use ($action) {
      if (ImportService::import($file_record, $action)) {
        FilesService::deleteFile($file_record);
      }
    });
    $last_department_id = DepartmentService::getNextId() - 1;
    $action->importData($last_department_id);
    return response()->json([
      'message' => 'Ok'
    ]);
  }
}
