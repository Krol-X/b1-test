<?php

namespace App\DTO\Resources;

use App\Models\UserInfo;

class UserInfoData
{
  private readonly array $data;

  public function __construct(array $data)
  {
    $this->data = array_intersect_key($data, UserInfo::fields);
  }

  public function __get($name)
  {
    return $this->data[$name] ?? null;
  }

  public function __isset($name)
  {
    return isset($this->data[$name]);
  }

  public function toArray(): array
  {
    return $this->data;
  }

  public function toJson()
  {
    return json_encode([]);
  }
}
