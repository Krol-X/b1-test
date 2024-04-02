<?php

namespace App\Http\Controllers\Resources;

use App\Abstract\Http\Controllers\ResourceController;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FilesController extends ResourceController {
  // post /files
  function create(Request $request): JsonResponse {
    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $file_name = time() . '_' . $file->getClientOriginalName();
      $record = FilesService::uploadFile($file, $file_name);
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
      'data' => $files->toJson()
    ]);
  }

  // get /files/{id}
  function read(Request $request, $id) {
    $file_path = FilesService::getFilePath($id);
    if ($file_path) {
      return Storage::download($file_path);
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
    $deleted = FilesService::deleteFile($id);
    if ($deleted) {
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
