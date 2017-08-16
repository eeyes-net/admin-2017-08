# 使用说明

## 用户权限API

登录权限管理系统，在后台添加相应的权限，并给指定用户相应的角色、权限

使用如下助手函数

```php
/**
 * 判断某CAS用户是否具有某权限
 *
 * @param string $username 用户名(NetId)
 * @param string $permission 权限代号
 *
 * @return array ['can' => mixed, 'msg' => string]
 */
function eeyes_admin_permission_check($username, $permission)
{
    return json_decode(file_get_contents('https://admin.eeyes.net/api/permission/can?' . http_build_query([
            'username' => $username,
            'permission' => $permission,
        ])), true);
}
```

返回一个assoc数组，如果`$result['can'] === true`即为拥有权限

## 用户令牌API

在后台添加令牌，指定对应的用户，设置过期时间

```php
/**
 * 获取token对应的CAS用户名
 *
 * @param string $token 令牌
 *
 * @return array ['username' => string|null, 'msg' => string]
 */
function eeyes_admin_token($token)
{
    return json_decode(file_get_contents('https://admin.eeyes.net/api/token?' . http_build_query([
            'token' => $token,
        ])), true);
}
```

返回一个assoc数组，如果`$result['username']`如果不为`null`即为用户名
