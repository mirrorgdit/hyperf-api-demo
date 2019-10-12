<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property string $uuid
 * @property string $username
 * @property string $password_hash
 * @property string $nickname
 * @property string $realname
 * @property string $head_portrait
 * @property int $gender
 * @property string $qq
 * @property string $email
 * @property string $birthday
 * @property string $mobile
 * @property int $last_time
 * @property string $last_ip
 * @property int $province_id
 * @property int $city_id
 * @property int $area_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    protected $dateFormat = 'U';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'gender' => 'integer', 'last_time' => 'integer', 'province_id' => 'integer', 'city_id' => 'integer', 'area_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}