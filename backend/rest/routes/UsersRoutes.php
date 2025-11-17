<?php
require_once __DIR__ . '/../services/UsersService.php';

/**
 * @OA\Get(
 *      path="/users",
 *      tags={"Users"},
 *      summary="Get all users",
 *      description="Returns a list of all users",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all users",
 *           @OA\JsonContent(
 *               type="object",
 *               example={
 *                   "success": true,
 *                   "data": {
 *                       { "id": 1, "first_name": "Alice", "last_name": "Smith", "email": "alice@test.com", "role": "user" },
 *                       { "id": 2, "first_name": "Bob", "last_name": "Johnson", "email": "bob@test.com", "role": "user" }
 *                   }
 *               }
 *           )
 *      )
 * )
 */
Flight::route('GET /users', function() {
    Flight::json(Flight::usersService()->getAll());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": true, "data": { "id": 1, "first_name": "Alice", "last_name": "Smith", "email": "alice@test.com", "role": "user" } }
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": false, "error": "User not found" }
 *         )
 *     )
 * )
 */
Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::usersService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"first_name","last_name","email","password"},
 *             @OA\Property(property="first_name", type="string", example="Selena"),
 *             @OA\Property(property="last_name", type="string", example="Huseinbasic"),
 *             @OA\Property(property="email", type="string", example="selena@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123"),
 *             @OA\Property(property="role", type="string", example="user"),
 *             @OA\Property(property="phone", type="string", example="123456789")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": true, "data": { "id": 39, "first_name": "Alice", "last_name": "Smith", "email": "alice@test.com", "role": "user" } }
 *         )
 *     )
 * )
 */
Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::usersService()->createUser($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update an existing user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=39)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="role", type="string"),
 *             @OA\Property(property="phone", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": true, "data": { "id": 39, "phone": "555-1234" } }
 *         )
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::usersService()->updateUser($id, $data));
});

/**
 * @OA\Patch(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Partially update a user",
 *     description="Update only the fields provided in the request body",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=39)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string", example="Alice"),
 *             @OA\Property(property="last_name", type="string", example="Smith"),
 *             @OA\Property(property="email", type="string", example="alice@example.com"),
 *             @OA\Property(property="password", type="string", example="newpassword123"),
 *             @OA\Property(property="role", type="string", example="user"),
 *             @OA\Property(property="phone", type="string", example="555-1234")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User partially updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": true, "data": { "id": 39, "phone": "555-1234" } }
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": false, "error": "User not found" }
 *         )
 *     )
 * )
 */
Flight::route('PATCH /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::usersService()->patchUser($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=39)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             example={ "success": true, "data": { "deleted": true, "id": 39 } }
 *         )
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    Flight::json(Flight::usersService()->delete($id));
});
