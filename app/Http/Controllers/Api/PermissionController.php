<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function can($username, Request $request)
    {
        $permission = $request->get('permission');
        $admin = Administrator::where('username', $username)->first();
        $can = null;
        $msg = 'Unknown error';
        if ($admin) {
            $can = $admin->can($permission);
            if ($can) {
                $msg = 'OK';
            } else {
                $msg = 'Forbidden';
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
