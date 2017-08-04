<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Database\Eloquent\ModelNotFoundException; // DATABASE(CONTROLLER->MODEL) DATA NOT FOUND ERROR HANDLING
use Illuminate\Database\QueryException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {



        // JWT
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['Handler.php token_expired'], $exception->getStatusCode());
        } else if ($exception instanceof TokenInvalidException) {
            return response()->json(['Handler.php token_invalid'], $exception->getStatusCode());
        } else if ($exception instanceof PayloadException) {
            return response()->JSON(['error' => 'Handler.php PayloadException error'], $exception->getStatusCode());
        }
        // else if ($exception instanceof JWTException) {
        //     return response()->json(['Handler.php invalid_email_or_password'], $exception->getStatusCode());
        // }
        // ELOQUENT
        // if ($exception instanceof ModelNotFoundException) { // database
        //     return response()->json(['error' => 'Handler.php Data not found'], 404);
        // }
        //  else if ($exception instanceof QueryException) { // database
        //     return response()->json(['error' => 'Handler.php data duplicate detected.']);
        // }



        if ($this->isHttpException($exception))
        {
          if ($exception instanceof NotFoundHttpException) {
              return response()->JSON(['error' => 'NotFoundHttpException',
                                       'status code' => $exception->getStatusCode()]);
          } else if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->JSON(['error' => 'MethodNotAllowedHttpException',
                                     'status code' => $exception->getStatusCode()]);
          }

          return response()->JSON(['error' => 'Unknown error',
                                   'status code' => $exception->getStatusCode()]);
        }






        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
