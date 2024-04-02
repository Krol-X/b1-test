<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FilesService {
  public static function uploadFile($file, $file_name) {
    return $file->storeAs('uploads', $file_name, 'public');
  }

  public static function listFiles() {
    return Storage::files('public/uploads');
  }

  public static function getFilePath($file_id) {
    $file_path = "public/uploads/$file_id";
    if (Storage::exists($file_path)) {
      return $file_path;
    }
    return null;
  }

  public static function deleteFile($file_id) {
    $file_path = "public/uploads/$file_id";
    if (Storage::exists($file_path)) {
      Storage::delete($file_path);
      return true;
    }
    return false;
  }
}
