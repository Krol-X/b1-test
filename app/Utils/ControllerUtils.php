<?php

namespace App\Utils;

class ControllerUtils {
  static function remap_fields($record, $map, $reverse = false): array {
    $result = [];
    if ($reverse) {
      $keys_db = array_keys($map);
      for ($i = 0; $i < count($keys_db); $i += 1) {
        $result[$keys_db[$i]] = $record[$i];
      }
    } else {
      foreach ($map as $key_db => $xml_db) {
        $result[$xml_db] = $record[$key_db];
      }
    }
//    foreach ($map as $key_db => $xml_db) {
//      $result[$reverse ? $key_db : $xml_db] = $record[$reverse ? $xml_db : $key_db];
//    }
    return $result;
  }

  static function convertId($id, string $prefix, bool $reverse = false) {
    $result = null;
    if ($id) {
      $result = $reverse
        ? intval(substr($id, strlen($prefix)))
        : $prefix . str_pad($id, 3, "0", STR_PAD_LEFT);
    }
    return $result;
  }
}
