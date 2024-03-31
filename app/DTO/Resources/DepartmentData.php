<?php

namespace App\DTO\Resources;

class DepartmentData {
  private readonly array $data;

  public function __construct(array $data) {
    $this->data = array_intersect_key($data, [
      'name',
      'parent_id'
    ]);
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
      'name' => $this->data['name'],
      'parent_id' => $this->data['parent_id']
    ]);
  }
}
