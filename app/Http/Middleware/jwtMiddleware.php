<?php
namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class jwtMiddleware
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
      if ($exception instanceof UnauthorizedHttpException) {
          // detect previous instance
          if ($exception->getPrevious() instanceof TokenExpiredException) {
              return response()->json(['error' => 'TOKEN_EXPIRED'], $exception->getStatusCode());
          } else if ($exception->getPrevious() instanceof TokenInvalidException) {
              return response()->json(['error' => 'TOKEN_INVALID'], $exception->getStatusCode());
          } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
              return response()->json(['error' => 'TOKEN_BLACKLISTED'], $exception->getStatusCode());
          } else {
              return response()->json(['error' => "UNAUTHORIZED_REQUEST"], 401);
          }
      }
      return parent::render($request, $exception);
    }
}
