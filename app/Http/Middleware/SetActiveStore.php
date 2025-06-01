<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetActiveStore
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $store = Store::where('domain', $host)->firstOrFail();
        App::instance('store.active', $store);
        return $next($request);
    }
} 