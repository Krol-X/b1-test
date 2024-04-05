<?php

namespace App\DTO\Resources;

use App\Models\Department;

class DepartmentData {
  private readonly array $data;

  public function __construct(array $data) {
    $this->data = array_filter($data, fn($value, $key) => in_array($key, Department::fields) && $value !== '', ARRAY_FILTER_USE_BOTH);
  }

  public function __get($name) {
    return $this->data[$name] ?? null;
  }

  public function __isset($name) {
    return isset($this->data[$name]);
  }

  public function toArray(): array {
    return $this->data;
  }

  public function toJson() {
    return json_encode([
      'id' => $this->data['id'],
      'name' => $this->data['name'],
      'parent_id' => $this->data['parent_id'],
    ]);
  }
}
