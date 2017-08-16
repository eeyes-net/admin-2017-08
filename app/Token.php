<?php

namespace App;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 *
 * @package App
 *
 * @property string $id ID
 * @property string $user_id admin_users表的外键
 * @property string $token 令牌
 * @property string $expire 令牌过期时间
 * @property string $remark 备注
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property \Encore\Admin\Auth\Database\Administrator $user
 * @property \Illuminate\Database\Eloquent\Collection $logs
 */
class Token extends Model
{
    public function user()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function logs()
    {
        return $this->hasMany(TokenLog::class);
    }
}
