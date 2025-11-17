<?php
require_once __DIR__ . '/../services/PackagesService.php';

/**
 * @OA\Get(
 *     path="/packages",
 *     tags={"Packages"},
 *     summary="Get all packages",
 *     @OA\Response(
 *         response=200,
 *         description="List of all packages"
 *     )
 * )
 */
Flight::route('GET /packages', function() {
    Flight::json(Flight::packagesService()->getAll());
});

/**
 * @OA\Get(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Get package by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the package",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Package found"
 *     )
 * )
 */
Flight::route('GET /packages/@id', function($id) {
    Flight::json(Flight::packagesService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/packages",
 *     tags={"Packages"},
 *     summary="Create a new package",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","price"},
 *             @OA\Property(property="name", type="string", example="Gold Package"),
 *             @OA\Property(property="description", type="string", example="Full luxury service"),
 *             @OA\Property(property="price", type="number", format="float", example=99.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New package created successfully"
 *     )
 * )
 */
Flight::route('POST /packages', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::packagesService()->createPackage($data));
});

/**
 * @OA\Put(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Update an existing package",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the package",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="price", type="number", format="float")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Package updated successfully"
 *     )
 * )
 */
Flight::route('PUT /packages/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::packagesService()->updatePackage($id, $data));
});

/**
 * @OA\Delete(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Delete package by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the package",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Package deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /packages/@id', function($id) {
    Flight::json(Flight::packagesService()->delete($id));
});
?>
