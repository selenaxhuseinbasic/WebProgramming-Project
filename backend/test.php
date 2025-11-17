<?php
require 'vendor/autoload.php';

echo "\n=== FULL SYSTEM TEST ===\n";

function pp($title, $response) {
    echo "\n--- $title ---\n";
    var_dump($response);
}

// ---------------- USERS ----------------
echo "\n=== USERS TEST ===\n";

$userData = [
    'first_name' => 'Temp',
    'last_name' => 'User',
    'email' => 'temp_user_' . rand(10000,99999) . '@example.com',
    'password' => 'password123',
    'phone' => '000111222',
    'role' => 'user'
];

// CREATE
$response = file_get_contents('http://localhost:8080/users', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($userData)
    ]
]));
$user = json_decode($response, true);
pp('Create User', $user);
$userId = $user['data']['id'];

// READ
$response = file_get_contents("http://localhost:8080/users/$userId");
pp('Read User', json_decode($response, true));

// UPDATE
$updateData = ['first_name' => 'UpdatedTemp'];
$response = file_get_contents("http://localhost:8080/users/$userId", false, stream_context_create([
    'http' => [
        'method' => 'PUT',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($updateData)
    ]
]));
pp('Update User', json_decode($response, true));

// ---------------- PACKAGES ----------------
echo "\n=== PACKAGES TEST ===\n";

$packageData = [
    'name' => 'Temp Package ' . rand(1000,9999),
    'description' => 'This is a test package',
    'price' => 49.99
];

// CREATE
$response = file_get_contents('http://localhost:8080/packages', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($packageData)
    ]
]));
$package = json_decode($response, true);
pp('Create Package', $package);
$packageId = $package['data']['id'];

// READ
$response = file_get_contents("http://localhost:8080/packages/$packageId");
pp('Read Package', json_decode($response, true));

// UPDATE
$updateData = ['name' => 'Updated Package', 'price' => 59.99];
$response = file_get_contents("http://localhost:8080/packages/$packageId", false, stream_context_create([
    'http' => [
        'method' => 'PUT',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($updateData)
    ]
]));
pp('Update Package', json_decode($response, true));

// ---------------- NEWSLETTER ----------------
echo "\n=== NEWSLETTER TEST ===\n";

$email = 'test_sub_' . rand(10000,99999) . '@example.com';
$response = file_get_contents('http://localhost:8080/newsletter', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode(['email' => $email])
    ]
]));
$subscription = json_decode($response, true);
pp('Subscribe Newsletter', $subscription);
$newsletterId = $subscription['data']['id'];

// READ
$response = file_get_contents("http://localhost:8080/newsletter/$newsletterId");
pp('Read Newsletter', json_decode($response, true));

// ---------------- BOOKINGS ----------------
echo "\n=== BOOKINGS TEST ===\n";

// CREATE booking using temp user & package
$bookingData = [
    'user_id' => $userId,
    'package_id' => $packageId,
    'booking_date' => date('Y-m-d H:i:s', strtotime('+1 day'))
];

$response = file_get_contents('http://localhost:8080/bookings', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($bookingData)
    ]
]));
$booking = json_decode($response, true);
pp('Create Booking', $booking);
$bookingId = $booking['data']['id'];

// READ
$response = file_get_contents("http://localhost:8080/bookings/$bookingId");
pp('Read Booking', json_decode($response, true));

// ---------------- CLEANUP ----------------
echo "\n=== CLEANUP ===\n";

// DELETE booking
$response = file_get_contents("http://localhost:8080/bookings/$bookingId", false, stream_context_create(['http'=>['method'=>'DELETE']]));
pp('Delete Booking', json_decode($response, true));

// DELETE user
$response = file_get_contents("http://localhost:8080/users/$userId", false, stream_context_create(['http'=>['method'=>'DELETE']]));
pp('Delete User', json_decode($response, true));

// DELETE package
$response = file_get_contents("http://localhost:8080/packages/$packageId", false, stream_context_create(['http'=>['method'=>'DELETE']]));
pp('Delete Package', json_decode($response, true));

// DELETE newsletter subscription
$response = file_get_contents("http://localhost:8080/newsletter/$newsletterId", false, stream_context_create(['http'=>['method'=>'DELETE']]));
pp('Delete Newsletter', json_decode($response, true));

// FETCH ALL to verify empty states
pp('Fetch All Users', json_decode(file_get_contents("http://localhost:8080/users"), true));
pp('Fetch All Packages', json_decode(file_get_contents("http://localhost:8080/packages"), true));
pp('Fetch All Bookings', json_decode(file_get_contents("http://localhost:8080/bookings"), true));
pp('Fetch All Newsletter', json_decode(file_get_contents("http://localhost:8080/newsletter"), true));

echo "\n=== FULL SYSTEM TEST COMPLETE ===\n";
?>
