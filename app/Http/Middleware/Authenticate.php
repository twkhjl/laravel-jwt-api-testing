<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use PhpParser\Node\Stmt\TryCatch;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            if($request->cookie('jwt')){

                $token = 'Bearer '.$request->cookie('jwt');
                $request->headers->set('Authorization',$token);
            }

            $this->authenticate($request, $guards);

            return $next($request);
        } catch (\Throwable $exception) {
            return response()->json($exception->getMessage());

        }


    }
}
