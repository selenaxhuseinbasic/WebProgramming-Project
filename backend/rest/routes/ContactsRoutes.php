<?php
require_once __DIR__ . '/../services/ContactsService.php';

/**
 * @OA\Get(
 *     path="/contacts",
 *     tags={"Contacts"},
 *     summary="Get all contacts",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all contacts",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="phone", type="string", example="123456789"),
 *                 @OA\Property(property="message", type="string", example="Hello there"),
 *                 @OA\Property(property="created_at", type="string", example="2025-11-17 00:00:00")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /contacts', function() {
    Flight::json(Flight::contactsService()->getAllContacts());
});

/**
 * @OA\Get(
 *     path="/contacts/{id}",
 *     tags={"Contacts"},
 *     summary="Get contact by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the contact",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the contact with the given ID",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="123456789"),
 *             @OA\Property(property="message", type="string", example="Hello there"),
 *             @OA\Property(property="created_at", type="string", example="2025-11-17 00:00:00")
 *         )
 *     )
 * )
 */
Flight::route('GET /contacts/@id', function($id) {
    Flight::json(Flight::contactsService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/contacts",
 *     tags={"Contacts"},
 *     summary="Create a new contact",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","message"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="123456789"),
 *             @OA\Property(property="message", type="string", example="Hello there")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact created",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="123456789"),
 *             @OA\Property(property="message", type="string", example="Hello there")
 *         )
 *     )
 * )
 */
Flight::route('POST /contacts', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactsService()->createContact($data));
});

/**
 * @OA\Delete(
 *     path="/contacts/{id}",
 *     tags={"Contacts"},
 *     summary="Delete contact by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the contact",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact deleted",
 *         @OA\JsonContent(
 *             @OA\Property(property="deleted", type="boolean", example=true),
 *             @OA\Property(property="id", type="integer", example=1)
 *         )
 *     )
 * )
 */
Flight::route('DELETE /contacts/@id', function($id) {
    Flight::json(Flight::contactsService()->delete($id));
});
?>
