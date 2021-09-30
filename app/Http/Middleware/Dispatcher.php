<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dispatcher
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->hasRole('Dispatcher')) {
            if (!$request->session()->has('usertype')) {
                return redirect()->route('watchers.dispatchers.login');
            }

            $usertype = $request->session()->get('usertype');

            if ($usertype == 'Watcher') {
                /*return response(json_encode(['error' => 'Unauthorised']), 401)
				->header('Content-Type', 'text/json');*/
                return redirect()->route('watchers.dashboard');
            }

            return $next($request);
        }

        if (Auth::user()->hasRole(['Super Admin', 'Admin'])) {
            return redirect()->route('dashboard');
        }
    }
}
