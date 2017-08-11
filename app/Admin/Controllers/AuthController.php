<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\Auth;
use phpCAS;

class AuthController extends Controller
{
    public function __construct()
    {
        phpCAS::client(CAS_VERSION_2_0, config('cas.host'), config('cas.port'), config('cas.context'));
        if (config('app.debug')) {
            phpCAS::setNoCasServerValidation();
        }
    }

    public function login()
    {
        phpCAS::forceAuthentication();
        $username = phpCAS::getUser();
        $user = Administrator::where('username', $username)->first();
        if ($user) {
            Auth::guard('admin')->login($user);
            admin_toastr(trans('admin::lang.login_successful'));
            return redirect()->intended(config('admin.prefix'));
        }
        return response('You are not authorized.', 403);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session_unset();
        session_destroy();
        return redirect(phpCAS::getServerLogoutURL() . '?' . http_build_query([
                'service' => url(config('admin.prefix'))
            ]));
    }
}
