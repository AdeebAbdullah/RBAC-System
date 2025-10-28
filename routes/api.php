<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


    //api
    Route::middleware('auth.user')->get('/api/test-auth', function (Request $request) {
        return response()->json([
            'message' => 'Authenticated user',
            'user' => $request->auth_user
        ]);
    });

    //read:article
    Route::middleware(['auth.user', 'permission:read:article'])
        ->get('/articles', function (Request $request){
            return response()->json([
                'message' => 'You can view articles!',
                'user' => $request->auth_user,
            ]);
        });

        //create:article
    Route::middleware(['auth.user', 'permission:create:article'])
        ->post('/articles', function (Request $request){
            return response()-> json([
                'message' => 'You can create a new article!',
                'user' => $request->auth_user,
            ]);
        });

        //delete:article 
    Route::middleware(['auth.user', 'permission:delete:article'])
        ->delete('/articles/{id}', function ($id, Request $request) {
            return response()->json([
                'message' => "You can delete article ID {$id}!",
                'user' => $request->auth_user,
            ]);
        });


