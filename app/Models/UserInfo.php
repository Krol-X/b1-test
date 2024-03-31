<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
  use HasFactory, SoftDeletes;

  public const fields = [
    'department_id',
    'last_name',
    'name',
    'second_name',
    'work_position',
    'mobile_phone',
    'phone',
    'login',
    'password',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = self::fields;
}
