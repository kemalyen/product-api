<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Product API",
 *      description="A sample product API application with L5 Swagger OpenApi, PHP Pest and Authentication",
 *      @OA\Contact(
 *          email=""
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * 
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 *
 * @OA\PathItem(path="/api")
 * 
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )

 *
 * @OA\Tag(
 *     name="Projects",
 *     description="API Endpoints of Projects"
 * )
 */
class Controller
{
}
