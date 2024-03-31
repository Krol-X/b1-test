<?php

namespace App\Services;

use App\DTO\Resources\UserInfoData;
use App\Models\UserInfo;
use Illuminate\Support\Collection;

class UserInfoService
{
  public static function createUserInfo(UserInfoData $info): UserInfo
  {
    $record = UserInfo::create($info->toArray());
    return $record;
  }

  public static function listUserInfos(callable $filter = null): Collection
  {
    $query = UserInfo::query();
    if ($filter && is_callable($filter)) {
      $query = $filter($query);
    } else {
      $query = $query->orderBy('created_at', 'desc');
    }
    return $query->get();
  }

  public static function getUserInfo(int $id): ?UserInfo
  {
    $record = UserInfo::find($id);
    return $record;
  }

  public static function updateUserInfo(UserInfo $record, UserInfoData $info): UserInfo
  {
    $record->update($info->toArray());
    return $record;
  }

  public static function deleteUserInfo(UserInfo $UserInfo): void
  {
    $UserInfo->delete();
  }

  public static function getTrashed(int $id): ?UserInfo
  {
    $trashed_record = UserInfo::withTrashed()->find($id);
    return $trashed_record;
  }

  public static function restoreUserInfo(int $id): ?UserInfo
  {
    $record = self::getTrashed($id);
    if ($record) {
      $record->restore();
      return $record;
    }
    return null;
  }
}
