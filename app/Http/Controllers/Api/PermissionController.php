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
        $permission_slug = $request->get('permission');
        $admin = Administrator::where('username', $username)->first();
        $can = null;
        $msg = 'Unknown error';
        if (!$admin) {
            $can = false;
            $msg = 'User not exists';
        } else {
            $permission = Permission::where('slug', $permission_slug)->first();
            if (!$permission) {
                $can = false;
                $msg = 'Permission not exists';
            } else {
                $can = $admin->can($permission_slug);
                if ($can) {
                    $msg = 'OK';
                } else {
                    $msg = 'Forbidden';
                }
            }
        }
        return [
            'can' => $can,
            'msg' => $msg,
        ];
    }
}
