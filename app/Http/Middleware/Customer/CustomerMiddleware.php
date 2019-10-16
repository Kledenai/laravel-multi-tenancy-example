<?php

namespace App\Http\Middleware\Customer;

use Closure;
use App\Models\Customer;

class CustomerMiddleware
{
    public function handle($request, Closure $next)
    {
        $customer = $this->getCustomer($request->getHost());

        if (!$customer) {
            return redirect()->route('404');
        }

        return $next($request);
    }

    public function getCustomer($host)
    {
        return Customer::where('subdomain', $host)->first();
    }
}
