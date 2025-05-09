<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\JWTAuth;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(empty($request->header('Authorization')) && empty($_COOKIE['user_token'])){
            return redirect(route('page.login'));
        }elseif($_COOKIE['user_token']){
            $token = JWTAuth::verifyToken(Cookie::get('user_token'),false);
        }else{
            $token = JWTAuth::verifyToken($request->header('Authorization'),false);
        }

        if($token){
            $request->merge(['user' => ['username' => $token->user, 'user_id' => $token->id]]);
            return $next($request);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ],401);
        }
    }
}
