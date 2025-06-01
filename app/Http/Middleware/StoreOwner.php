<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Store;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(403, 'Unauthorized access to store management.');
        }

        // Get the store owned by the user
        $store = Store::where('user_id', $user->id)->first();
        
        if (!$store) {
            abort(403, 'No store found for this user.');
        }

        // Set the active store
        app()->instance('store.active', $store);

        return $next($request);
    }
} 