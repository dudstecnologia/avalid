<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Inertia\Inertia;

class Funcionario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (UserService::admin()) {
            return Inertia::render('Auth/SemPermissao');
        }
        
        return $next($request);
    }
}
