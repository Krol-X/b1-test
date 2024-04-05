<?php


namespace App\Http\Controllers\Resources;

use App\Services\FilesService;
use App\Services\ImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ImportController extends BaseController {
  function import(Request $request): JsonResponse {
    $files = FilesService::listFiles();
    $files->each(function ($file_record) {
      if (ImportService::import($file_record)) {
        // FilesService::deleteFile($file_record);
      }
    });
    return response()->json([
      'message' => 'Ok'
    ]);
  }
}
