<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="RBAC System API",
 *     version="1.0.0",
 *     description="Role-Based Access Control API Documentation"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="userAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Use format: User <username>\nExample: User admin"
 * )
 */
abstract class Controller
{
    //
}
