<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show(Request $request)
    {
        $token_value = $request->get('token');
        $token = Token::where('token', $token_value)->first();
        $username = null;
        $msg = 'Unknown error';
        if (!$token) {
            $username = null;
            $msg = 'Token not exists';
        } elseif (Carbon::parse($token->expire)->lessThanOrEqualTo(Carbon::now())) {
            $username = null;
            $msg = 'Token expired at ' . $token->expire;
        } else {
            $user = $token->user;
            if (!$user) {
                $username = null;
                $msg = 'User not exists';
            } else {
                $username = $user->username;
                $msg = 'OK';
            }
        }
        return [
            'username' => $username,
            'msg' => $msg,
        ];
    }
}
