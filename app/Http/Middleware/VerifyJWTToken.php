<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use App\Exceptions\Handler;

class VerifyJWTToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, \Closure $next)
     {
         if (! $token = $this->auth->setRequest($request)->getToken()) {
             return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
         }

         try {
             $user = $this->auth->authenticate($token);
         } catch (JWTException $e) {
             $handler = new Handler();
             $handler->render($request, $e);
         }

         if (! $user) {
             return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
         }

         $this->events->fire('tymon.jwt.valid', $user);

         return $next($request);
     }
}
