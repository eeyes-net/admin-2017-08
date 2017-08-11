<?php

namespace App;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLog
 *
 * @package App
 *
 * @property int $id ID
 * @property string $username 用户名(NetId)
 * @property int $user_id admin_users表的外键
 * @property string $permission 权限名
 * @property string $path 网址
 * @property string $ip IP
 * @property string $response 返回的json
 * @property string $created_at 记录时间
 * @property string $updated_at 修改记录时间（无用）
 */
class ApiLog extends Model
{
    public function user()
    {
        return $this->hasOne(Administrator::class);
    }
}
