<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

/**
 * @OA\Tag(name="Articles")
 * @OA\SecurityRequirement(name="userAuth")
 */
class ArticleController extends Controller
{
    //implement function

/**
 * @OA\Get(
 *     path="/api/articles",
 *     summary="Get all articles",
 *     tags={"Articles"},
 *     security={{"userAuth":{}}},
 *     @OA\Response(response=200, description="List of articles"),
 *     @OA\Response(response=401, description="Unauthorized")
 * )
 */
    public function index(Request $request){ 
        $articles = Article::orderBy('created_at', 'desc')-> get();
        return response()->json([
            'message' => 'Article retrieved successfully',
            'articles' => $articles
        ], 200);
    }

/**
 * @OA\Post(
 *     path="/api/articles",
 *     summary="Create a new article",
 *     tags={"Articles"},
 *     security={{"userAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title","body"},
 *             @OA\Property(property="title", type="string", example="My First Article"),
 *             @OA\Property(property="body", type="string", example="This is the article body.")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Article created successfully"),
 *     @OA\Response(response=403, description="Forbidden"),
 *     @OA\Response(response=401, description="Unauthorized")
 * )
 */
    public function store(Request $request){ 
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        $article = Article::create([
            'title' => $request->title,
            'body'=> $request->body,
            'author_id' => $request->auth_user->id
        ]);

        return response()->json([
            'message'=> 'Article created successfully',
            'article' => $article
        ], 201);
    }

/**
 * @OA\Delete(
 *     path="/api/articles/{id}",
 *     summary="Delete an article by ID",
 *     tags={"Articles"},
 *     security={{"userAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Article ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(response=204, description="Article deleted successfully"),
 *     @OA\Response(response=403, description="Forbidden"),
 *     @OA\Response(response=404, description="Article not found"),
 *     @OA\Response(response=401, description="Unauthorized")
 * )
 */
    public function destroy($id, Request $request){ 
        $article = Article::find($id);
        if(!$article){
            return response()->json([
                'error' => 'Article not found'
            ], 404);
        }

        $article->delete();

        return response()->json([
            'message' => "Article ID {$id} deleted successfully"
        ], 204);


    }
}
