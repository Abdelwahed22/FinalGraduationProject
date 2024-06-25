<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()){
            $user=User::find($request->user()->id);
            if($user->Active=="blocked"){
                $request->user()->currentAccessToken()->delete();

                return ApiResponse::sendResponse(404,"you are blocked",null);
            }
        }
        return $next($request);
    }
}
