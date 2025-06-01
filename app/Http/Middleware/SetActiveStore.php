<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;
use Symfony\Component\HttpFoundation\Response;

class SetActiveStore
{
    public function __construct()
    {
        // Register store.active singleton if not already registered
        if (!app()->bound('store.active')) {
            app()->singleton('store.active', function () {
                return null;
            });
        }
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Get store from URL slug
        $slug = $request->route('slug');
        
        if ($slug) {
            $store = Store::where('slug', $slug)->first();
            if ($store) {
                app()->instance('store.active', $store);
            }
        }

        return $next($request);
    }
} 