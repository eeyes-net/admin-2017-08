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
        if (!$admin) {
            $can = false;
            $msg = 'User not exists';
        } else {
            $permission = Permission::where('slug', $permission)->first();
            if (!$permission) {
                $can = false;
                $msg = 'Permission not exists';
            } else {
                $can = $admin->can($permission);
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
