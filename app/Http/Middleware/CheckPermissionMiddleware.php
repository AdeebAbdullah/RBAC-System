<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Article;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Get the authenticated user (from AuthenticateUserMiddleware)
        $user = $request->auth_user ?? null;

        // If no authenticated user found
        if (!$user) {
            return response()->json(['error' => 'Unauthorized: No user found'], 401);
        }

        // Retrieve the user's role and permissions
        $role = $user->role;
        $permissions = $role ? $role->permissions->pluck('name')->toArray() : [];

        // Check if user has the required permission
        if (!in_array($permission, $permissions)) {
            return response()->json(['error' => 'Forbidden: Permission denied'], 403);
        }

        //editor delete its own article 
        if ($permission === 'delete:article' && $role->name === 'EDITOR') {
            $articleId = $request->route('id'); // Get {id} from route
            $article = Article::find($articleId);

            // Deny if article not found OR editor is not the author
            if (!$article || $article->author_id !== $user->id) {
                return response()->json([
                    'error' => 'Forbidden: You can only delete your own article'
                ], 403);
            }

            // If editor owns the article, allow deletion
            return $next($request);
        }

        if (!in_array($permission, $permissions)) {
            return response()->json(['error' => 'Forbidden: Permission denied'], 403);
        }
        // Allow the request to continue
        return $next($request);
    }
}
