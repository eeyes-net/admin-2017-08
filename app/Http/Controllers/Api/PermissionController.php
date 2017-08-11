<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function can(Request $request)
    {
        $username = $request->get('username');
        $permission = $request->get('permission');
        $admin = Administrator::where('username', $username)->first();
        $can = null;
        $msg = 'Unknown error';
        if ($admin) {
            $can = $admin->can($permission);
            if ($can) {
                $msg = 'OK';
            } else {
                $permission = Permission::where('name', $permission)->first();
                if ($permission) {
                    $msg = 'Forbidden';
                } else {
                    $msg = 'Permission not exists';
                }
            }
        } else {
            $msg = 'User not exists';
            $can = false;
        }
        return [
            'can' => $can,
            'msg' => $msg,
        ];
    }
}
