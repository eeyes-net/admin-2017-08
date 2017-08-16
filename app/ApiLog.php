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
 * @property string $permission 权限名
 * @property string $method HTTP方法
 * @property string $path 网址
 * @property string $ip IP
 * @property string $query Query string
 * @property string $body POST body
 * @property string $response 返回的json
 * @property string $created_at 记录时间
 * @property string $updated_at 修改记录时间（无用）
 */
class ApiLog extends Model
{
}
