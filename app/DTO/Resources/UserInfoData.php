<?php

namespace App\DTO\Resources;

use App\Models\User;
use App\Models\UserInfo;

class UserInfoData {
  private readonly array $data;

  public function __construct(array $data) {
    $this->data = array_filter(
      $data,
      fn($value, $key) => in_array($key, UserInfo::fields),
      ARRAY_FILTER_USE_BOTH);
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
}
