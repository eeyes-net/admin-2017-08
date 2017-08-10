<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function can($username, Request $request)
    {
        $permission = $request->get('permission');
        $admin = Administrator::where('username', $username)->get();
        if ($admin) {
            $can = $admin->can($permission);
        } else {
            $can = false;
        }
        return [
            'can' => $can,
        ];
    }
}
