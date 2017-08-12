# e瞳统一权限管理系统

<https://admin.eeyes.net/>

## 部署

### 环境要求

* `php >= 5.6.4`
* 具体环境要求请参考[Laravel 5.4 Server Requirements](https://laravel.com/docs/5.4#server-requirements)

### 安装步骤

1. 将代码解压到服务器
2. 创建数据库、用户
3. `composer install`
4. 修改`.env`文件中的数据库、用户名、密码，应用URL，CAS域名、端口
5. `php artisan vendor:publish --tag=laravel-admin`
6. `php artisan admin:install`
7. `php artisan admin:menu:install`
8. `php artisan storage:link`
9. 将服务器的根目录设置在`public/`目录下

## 说明

### 使用方法

首先登录权限管理系统，在后台添加相应的权限，并给指定用户相应的角色、权限

子应用代码中使用下方的函数，返回是一个assoc数组，如果`$result['can'] === true`即为拥有权限

```php
/**
 * 检查e瞳统一管理权限
 *
 * @param string $username 用户名(NetId)
 * @param string $permission 权限代号
 *
 * @return array ['can' => mixed, 'msg' => string]
 */
function eeyes_admin_permission_check($username, $permission)
{
    return json_decode(file_get_contents('http://admin.dev/api/permission/can?' . http_build_query([
            'username' => $username,
            'permission' => $permission,
        ])), true);
}
```

### 参考文献

* [Laravel Documentation](https://laravel.com/docs/5.4)
* [Laravel Admin Documentation](https://z-song.github.io/laravel-admin/#/zh/)

### 本应用基础开发过程十分简单

1. `composer create-project --prefer-dist laravel/laravel admin`
2. 创建数据库、用户
3. 修改`.env`文件中的数据库、用户名、密码，应用URL，CAS域名、端口
4. `composer require encore/laravel-admin`
5. `php artisan vendor:publish --tag=laravel-admin`
6. `php artisan admin:install`
7. `php artisan storage:link`
8. `php artisan make:controller Api/AdminController`
9. 编辑`app/Http/Controllers/Api/AdminController.php`，添加API逻辑
10. 在`routes/api.php`中添加相应路由
11. API记录、CAS登录等附加功能不做说明

* 使用`php artisan serve`测试（注意：php-cli或php-cgi的单线程服务器相互调用会造成阻塞）

## CONTRIBUTORS

* [Ganlv @ganlvtech](https://github.com/ganlvtech)

## LICENSE

    Copyright (c) 2017 eeyes.net
    
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.