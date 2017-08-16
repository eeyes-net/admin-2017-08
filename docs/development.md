# 本应用开发说明

## 基础功能开发过程

1. `composer create-project --prefer-dist laravel/laravel admin`
2. 创建数据库、用户
3. 修改`.env`文件中的数据库、用户名、密码
4. `composer require encore/laravel-admin`
5. `php artisan vendor:publish --tag=laravel-admin`
6. `php artisan admin:install`
7. `php artisan storage:link`
8. `php artisan make:controller Api/AdminController`
9. 编辑`app/Http/Controllers/Api/AdminController.php`，添加API逻辑
10. 在`routes/api.php`中添加相应路由

## 说明

* API记录、CAS登录等附加功能不做说明
* 使用`php artisan serve`测试（注意：php-cli或php-cgi的单线程服务器相互调用会造成阻塞）

## 参考文献

* [Laravel Documentation](https://laravel.com/docs/5.4)
* [Laravel Admin Documentation](https://z-song.github.io/laravel-admin/#/zh/)
