<?php

namespace App\Http\Middleware\Api;

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
            $apiLog->method = $request->method();
            $apiLog->path = $request->path();
            $apiLog->ip = $request->ip();
            $apiLog->query = $request->getQueryString();
            $apiLog->body = $request->getContent();
            $apiLog->response = '';
            $apiLog->save();
        }

        /** @var Response $response */
        $response = $next($request);

        if (isset($apiLog)) {
            $apiLog->response = json_encode($response->getOriginalContent(), JSON_UNESCAPED_UNICODE);
            $apiLog->save();
        }

        return $response;
    }
}
