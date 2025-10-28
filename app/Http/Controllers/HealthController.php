<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HealthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/health",
     *     summary="Health Check Endpoint",
     *     tags={"System"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns ok:true"
     *     )
     * )
     */
    public function check(){ 
        return response()->json([
            'ok' => true
        ], 200);
    }
}
