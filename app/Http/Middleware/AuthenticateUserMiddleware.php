<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Article;

class AuthenticateUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //authorization header
        $authHeader = $request->header('Authorization');

        // if no = 401 error
        if(!$authHeader){
            return response()->json(['error' => 'Unauthorized: Invalid header format'], 401);
        }

        // header = User +space +word characters
        if(!preg_match('/^User\s+(\w+)$/', $authHeader, $matches)){
            return response()->json(['error' => 'Unauthorized: invalid header format'], 401);
        }

        //username in [1]
        $username = $matches[1];

        //find user in  db
        $user = User::where('username', $username)-> first();

        if(!$user){
            return response()->json(['error'=> 'Unauthorized: Unknown user'], 401);
        }

        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}
