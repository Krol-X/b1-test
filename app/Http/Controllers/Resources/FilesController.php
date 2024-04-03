<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilesController extends ResourceController {
  // post /files
  function create(Request $request): JsonResponse {
    if ($request->hasFile('file')) {
      $file = $request->file('file');

      $record = FilesService::uploadFile($file);
      if ($record) {
        return response()->json(
          [
            'message' => 'File uploaded successfully',
            'data' => $record->toJson(),
          ],
          Response::HTTP_CREATED
        );
      }
    }
    return response()->json(
      ['message' => 'Cannot upload file'],
      Response::HTTP_INTERNAL_SERVER_ERROR
    );
  }

  // get /files
  function list(Request $request): JsonResponse {
    $files = FilesService::listFiles();
    return response()->json([
      'message' => 'Ok',
      'data' => $files
    ]);
  }

  // get /files/{id}
  function read(Request $request, $id): StreamedResponse|JsonResponse {
    $record = FilesService::getRecord($id);
    if ($record) {
      $file_path = FilesService::getFilePath($record);
      if ($file_path) {
        return Storage::download($file_path);
      }
    }
    return response()->json(
      ['message' => 'File not found'],
      Response::HTTP_NOT_FOUND
    );
  }

  function update(Request $request, $id) {
    // Stub
  }

  // delete /files/{id}
  function delete(Request $request, $id): JsonResponse {
    $record = FilesService::getRecord($id);
    if ($record) {
      FilesService::deleteFile($record);
      return response()->json([
        'message' => 'File deleted successfully',
        'id' => $id
      ]);
    }
    return response()->json(
      ['message' => 'File not found'],
      Response::HTTP_NOT_FOUND
    );
  }
}
