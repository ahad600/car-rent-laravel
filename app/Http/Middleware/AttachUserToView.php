<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;


class AttachUserToView
{
    public function handle($request, Closure $next)
    {
        $is_authenticate = false;
        $role = null;
        $name = null;

        $token = $request->cookie('token');
        $result = JWTToken::ReadToken($token);
        if ($result == "unauthorized") {
            $is_authenticate = false;
            $role = null;
            $name = null;
        } else {
            $is_authenticate = true;
            $role = $result->role;
            $name = $result->name;
        }

        view()->share('is_authenticated', $is_authenticate);
        view()->share('role', $role);
        view()->share('name', $name);

        return $next($request);
    }
}
