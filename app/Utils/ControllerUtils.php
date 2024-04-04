<?php

namespace App\Utils;

class ControllerUtils {
  static function remap_fields($record, $map, $reverse = false): array {
    $result = [];
    foreach ($map as $key_db => $xml_db) {
      $result[$reverse ? $key_db : $xml_db] = $record[$reverse ? $xml_db : $key_db];
    }
    return $result;
  }

  static function convert_id($id, string $prefix, bool $reverse = false) {
    $result = '';
    if ($id) {
      $result = $reverse
        ? intval(substr($id, count_chars($prefix)))
        : $prefix . str_pad($id, 3, "0", STR_PAD_LEFT);
    }
    return $result;
  }
}
