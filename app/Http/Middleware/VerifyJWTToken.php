<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class VerifyJWTToken
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
      // caching the next action
       $response = $next($request);

        try{
            // THIS MIDDLEWARE VALIDATE THE $request->input "token"(?token=...)

            $user = JWTAuth::toUser(JWTAuth::getToken());
        }catch (JWTException $e) {
            // Token expired
           if($e instanceof TokenExpiredException) {
                try {
                    $newToken = JWTAuth::refresh(JWTAuth::getToken());
                    JWTAuth::setToken($newToken);
                    $user = JWTAuth::authenticate($newToken);
                    //$user = JWTAuth::toUser($newToken);
                    return response()->json([$user, $newToken]);
                } catch (JWTException $e) {

                    if($e instanceof TokenInvalidException) {
                        return response()->json(["Token_invalid", $e->getStatusCode()]);
                    }
                }
                // without using ?token=
                //$response->headers->set('Authorization', 'Bearer ' . $refreshedToken);
            // Token invalid
            }else if ($e instanceof TokenInvalidException) {
                return response()->json(['token_invalid'], $e->getStatusCode());
            // No token specify
            }else{
                return response()->json(['error'=>'Token is required']);
            }
        }

        return $response;
    }
}
