<?php

namespace App\Http\Middleware;

use App\Helper\Variable as CommonVariable;


use Closure;


class Variable
{
    public function handle($request, Closure $next)
    {
        view()->share('brands', CommonVariable::$brands);
        view()->share('models', CommonVariable::$models);
        view()->share('car_types', CommonVariable::$car_types);
        view()->share('rent_status', CommonVariable::$rent_status);

        return $next($request);
    }
}
