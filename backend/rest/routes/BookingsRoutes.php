<?php
require_once __DIR__ . '/../services/BookingsService.php';

/**
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=19),
 *     @OA\Property(property="user_id", type="integer", example=45),
 *     @OA\Property(property="package_id", type="integer", example=30),
 *     @OA\Property(property="booking_date", type="string", format="date-time", example="2025-12-01 10:00:00"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-16 23:24:23"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-16 23:24:23")
 * )
 */

/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"Bookings"},
 *     summary="Get all bookings",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all bookings",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Booking"))
 *         )
 *     )
 * )
 */
Flight::route('GET /bookings', function() {
    Flight::json(Flight::bookingsService()->getAll());
});

/**
 * @OA\Get(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Get booking by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Booking ID",
 *         @OA\Schema(type="integer", example=19)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", ref="#/components/schemas/Booking")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="error", type="string", example="Booking not found")
 *         )
 *     )
 * )
 */
Flight::route('GET /bookings/@id', function($id) {
    Flight::json(Flight::bookingsService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/bookings",
 *     tags={"Bookings"},
 *     summary="Create a new booking",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id","package_id","booking_date"},
 *             @OA\Property(property="user_id", type="integer", example=45),
 *             @OA\Property(property="package_id", type="integer", example=30),
 *             @OA\Property(property="booking_date", type="string", format="date-time", example="2025-12-01 10:00:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", ref="#/components/schemas/Booking")
 *         )
 *     )
 * )
 */
Flight::route('POST /bookings', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingsService()->createBooking($data));
});

/**
 * @OA\Delete(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Delete booking by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Booking ID",
 *         @OA\Schema(type="integer", example=19)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=19),
 *                 @OA\Property(property="deleted", type="boolean", example=true)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="error", type="string", example="Booking not found")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /bookings/@id', function($id) {
    Flight::json(Flight::bookingsService()->delete($id));
});
?>
