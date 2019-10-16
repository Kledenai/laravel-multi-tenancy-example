<?php

namespace App\Http\Middleware\Customer;

use Closure;
use App\Models\Customer;
use App\Customer\ManagerCustomer;

class CustomerMiddleware
{
    public function handle($request, Closure $next)
    {
        $customer = $this->getCustomer($request->getHost());

        if (!$customer &&  $request->url() != route('404.error')) {
            return redirect()->route('404.error');
        } else if ($request->url() != route('404.error')) {
            app(ManagerCustomer::class)->setConnection($customer);
        }

        return $next($request);
    }

    public function getCustomer($host)
    {
        return Customer::where('subdomain', $host)->first();
    }
}
