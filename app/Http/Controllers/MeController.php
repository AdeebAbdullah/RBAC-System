<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Me")
 * @OA\SecurityRequirement(name="userAuth")
 */
class MeController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/me",
 *     summary="Get authenticated user info",
 *     tags={"Users"},
 *     security={{"userAuth":{}}},
 *     @OA\Response(response=200, description="User info returned successfully"),
 *     @OA\Response(response=401, description="Unauthorized")
 * )
 */
    public function me(Request $request){ 
        
        $user = $request->auth_user;
        //get role->permissions
        $permissions = $user->role->permissions->pluck('name')->toArray();

        //hide special case editor (delete its own article)
        //so only display general permission for editor (read, create)
        if ($user->role->name === 'EDITOR') {
            $permissions = array_filter($permissions, fn($perm) => $perm !== 'delete:article'); 
        }

        return response()->json([
            'username'=> $user->username,
            'role'=> $user->role->name,
            'permission'=>array_values($permissions),
        ], 200);
    
    }
}
