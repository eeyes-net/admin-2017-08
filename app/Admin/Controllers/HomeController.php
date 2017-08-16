<?php

namespace App\Admin\Controllers;

use App\ApiLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
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
                $row->column(3, new InfoBox('Api Logs', 'history', 'yellow', '/admin/', ApiLog::count()));
            });

            /**
             * Permission API Log Block
             */

            $headers = ['Id', 'Username', 'Permission', 'Response', 'Time'];

            $rows = ApiLog::latest()->where('path', 'api/permission/can')->paginate()->map(function ($item) {
                return [
                    $item->id,
                    $item->username,
                    $item->permission,
                    $item->response,
                    $item->created_at,
                ];
            })->toArray();

            $content->row((new Box('Permission API Log', new Table($headers, $rows)))->style('primary')->solid());

            /**
             * Token API Log Block
             */

            $headers = ['Id', 'Token', 'Response', 'Time'];

            $rows = ApiLog::latest()->where('path', 'api/token')->paginate()->map(function ($item) {
                parse_str($item->query, $query);
                return [
                    $item->id,
                    $query['token'],
                    $item->response,
                    $item->created_at,
                ];
            })->toArray();

            $content->row((new Box('Token API Log', new Table($headers, $rows)))->style('info')->solid());
        });
    }
}
