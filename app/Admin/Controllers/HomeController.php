<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\OperationLog;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');

            $content->row(function ($row) {
                $row->column(3, new InfoBox('Users', 'user', 'aqua', '/admin/auth/users', Administrator::count()));
                $row->column(3, new InfoBox('Roles', 'users', 'green', '/admin/auth/roles', Role::count()));
                $row->column(3, new InfoBox('Permissions', 'check', 'red', '/admin/auth/permissions', Permission::count()));
                $row->column(3, new InfoBox('Logs', 'file-text', 'yellow', '/admin/files', OperationLog::count()));
            });

            $headers = ['Id', 'Username', 'Permission', 'Response', 'Time'];
            $rows = [
                [1, 'Jack', 'Post new article', 'True', '1997-08-13 13:59:21'],
                [2, 'Jack', 'Edit article', 'False', '1988-07-19 03:19:08'],
                [3, 'Jack', 'Post article', 'True', '1978-06-19 11:12:57'],
                [4, 'Mary', 'Post article', 'False', '1988-09-07 23:57:45'],
                [5, 'Mary', 'Delete article', 'True', '2013-10-16 10:00:01'],
                [5, 'Anonymous', 'Delete article', 'User not exists', '2013-10-16 10:00:01'],
            ];

            $content->row((new Box('Permission API Log', new Table($headers, $rows)))->style('info')->solid());
        });
    }
}
