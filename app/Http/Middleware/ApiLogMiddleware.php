<?php

namespace App\Http\Middleware;

use App\ApiLog;
use Closure;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('settings.api_log')) {
            $apiLog = new ApiLog();
            $apiLog->username = mb_substr($request->get('username'), 0, 190);
            $apiLog->permission = mb_substr($request->get('permission'), 0, 50);
            $apiLog->user_id = null;
            $apiLog->path = $request->path();
            $apiLog->ip = $request->getClientIp();
            $apiLog->response = '';
            $apiLog->save();
        }

        /** @var Response $response */
        $response = $next($request);

        if (isset($apiLog)) {
            $admin = Administrator::where('username', $apiLog->username)->first();
            if ($admin) {
                $apiLog->user_id = $admin->id;
            }
            $apiLog->response = json_encode($response->getOriginalContent(), JSON_UNESCAPED_UNICODE);
            $apiLog->save();
        }

        return $response;
    }
}
