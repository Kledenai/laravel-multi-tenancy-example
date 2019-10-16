<?php

namespace App\Http\Middleware\Customer;

use Closure;

class CheckDomainMain
{
    public function handle($request, Closure $next)
    {
        if ($request->getHost() != config('customer.domain_main')) {
            abort(401);
        }


        return $next($request);
    }
}
