<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class FilesService {
  public static function uploadFile($file) {
    $name = $file->getClientOriginalName();
    $saved_as = time() . '_' . $name;
    $file->storeAs('uploads', $saved_as, 'public');
    $record = File::create([
      'name' => $name,
      'saved_as' => $saved_as
    ]);
    return $record;
  }

  public static function listFiles(callable $filter = null): Collection {
    $query = File::query();
    if ($filter && is_callable($filter)) {
      $query = $filter($query);
    }
    return $query->get();
  }

  public static function getRecord($id) {
    $record = File::find($id);
    return $record;
  }

  public static function getFilePath($record) {
    $saved_as = $record->saved_as;
    $file_path = "public/uploads/$saved_as";
    if (Storage::exists($file_path)) {
      return $file_path;
    }
    return null;
  }

  public static function deleteFile(File $record): void {
    $file_path = self::getFilePath($record);
    if (Storage::exists($file_path)) {
      Storage::delete($file_path);
    }
    $record->delete();
  }
}
