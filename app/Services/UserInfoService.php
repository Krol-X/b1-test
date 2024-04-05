<?php

namespace App\Services;

use App\DTO\Resources\UserInfoData;
use App\Models\UserInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserInfoService {
  public static function createUserInfo(UserInfoData $info): UserInfo {
    $record = UserInfo::create($info->toArray());
    return $record;
  }

  public static function listUserInfos(callable $filter = null): Collection {
    $query = UserInfo::query();
    if ($filter && is_callable($filter)) {
      $query = $filter($query);
    }
    return $query->get();
  }

  public static function getUserInfo(int $id): ?UserInfo {
    $record = UserInfo::find($id);
    return $record;
  }

  public static function updateUserInfo(UserInfo $record, UserInfoData $info): UserInfo {
    $record->update($info->toArray());
    return $record;
  }

  public static function deleteUserInfo(UserInfo $record): void {
    $record->delete();
  }

  public static function getTrashed(int $id): ?UserInfo {
    $trashed_record = UserInfo::withTrashed()->find($id);
    return $trashed_record;
  }

  public static function restoreUserInfo(int $id): ?UserInfo {
    $record = self::getTrashed($id);
    if ($record) {
      $record->restore();
      return $record;
    }
    return null;
  }

  public static function deleteAllUserInfos(): void {
    DB::table('user_infos')->delete();
    DB::statement('ALTER TABLE user_infos AUTO_INCREMENT = 1');
  }
}
