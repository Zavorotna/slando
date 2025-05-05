<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Rate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rates = Rate::select('id', 'currency', 'exchange_rate')->where('currency', '!=', 'uah')->get()->toArray();
        session()->put('rates', $rates);
        return $next($request);
    }
}
