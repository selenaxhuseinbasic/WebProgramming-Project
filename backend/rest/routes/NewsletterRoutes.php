<?php
require_once __DIR__ . '/../services/NewsletterService.php';

/**
 * @OA\Get(
 *     path="/newsletter",
 *     tags={"Newsletter"},
 *     summary="Get all newsletter subscriptions",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all newsletter subscriptions"
 *     )
 * )
 */
Flight::route('GET /newsletter', function() {
    Flight::json(Flight::newsletterService()->getAllSubscriptions());
});

/**
 * @OA\Get(
 *     path="/newsletter/{id}",
 *     tags={"Newsletter"},
 *     summary="Get newsletter subscription by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the subscription",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Subscription retrieved"
 *     )
 * )
 */
Flight::route('GET /newsletter/@id', function($id) {
    Flight::json(Flight::newsletterService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/newsletter",
 *     tags={"Newsletter"},
 *     summary="Subscribe to newsletter",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="string", example="selena@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Subscription created"
 *     )
 * )
 */
Flight::route('POST /newsletter', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::newsletterService()->subscribe($data));
});

/**
 * @OA\Delete(
 *     path="/newsletter/{id}",
 *     tags={"Newsletter"},
 *     summary="Delete subscription by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the subscription",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Subscription deleted"
 *     )
 * )
 */
Flight::route('DELETE /newsletter/@id', function($id) {
    Flight::json(Flight::newsletterService()->delete($id));
});
