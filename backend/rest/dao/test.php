<?php
require_once 'UsersDao.php';
require_once 'PackagesDao.php';
require_once 'BookingsDao.php';
require_once 'ContactsDao.php';
require_once 'NewsletterDao.php';

// Initialize DAOs
$usersDao = new UsersDao();
$packagesDao = new PackagesDao();
$bookingsDao = new BookingsDao();
$contactsDao = new ContactsDao();
$newsletterDao = new NewsletterDao();

// Clean old test data to prevent errors :)
echo "- CLEANING OLD TEST DATA -\n";
$users = $usersDao->getAll();
foreach ($users as $user) {
    if ($user['email'] === 'selena@example.com') $usersDao->delete($user['id']);
}
$packages = $packagesDao->getAll();
foreach ($packages as $package) $packagesDao->delete($package['id']);
$bookings = $bookingsDao->getAll();
foreach ($bookings as $booking) $bookingsDao->delete($booking['id']);
$contacts = $contactsDao->getAll();
foreach ($contacts as $contact) $contactsDao->delete($contact['id']);
$newsletterSubs = $newsletterDao->getAll();
foreach ($newsletterSubs as $sub) $newsletterDao->delete($sub['id']);
echo "Clean complete.\n\n";

// Users CRUD
echo "- USERS -\n";
$user = $usersDao->add([
    'first_name' => 'Selena',
    'last_name' => 'Huseinbasic',
    'email' => 'selena@example.com',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'phone' => '1234567890',
    'role' => 'user'
]);
print_r($usersDao->getAll());

// Read by ID
$fetchedUser = $usersDao->getById($user['id']);
echo "Fetched user by ID:\n";
print_r($fetchedUser);

// Read by Email
$fetchedUserEmail = $usersDao->getByEmail('selena@example.com');
echo "Fetched user by Email:\n";
print_r($fetchedUserEmail);

// Update
$usersDao->update(['phone' => '0987654321'], $user['id']);
$updatedUser = $usersDao->getById($user['id']);
echo "Updated user phone:\n";
print_r($updatedUser);

// Update profile (specific UsersDao method)
$usersDao->updateProfile($user['id'], [
    'first_name' => 'SelenaUpdated',
    'last_name' => 'HuseinbasicUpdated',
    'phone' => '111222333',
    'password' => 'newpass123'
]);
$profileUpdatedUser = $usersDao->getById($user['id']);
echo "Profile updated user:\n";
print_r($profileUpdatedUser);

// Delete
$usersDao->delete($user['id']);
echo "Deleted user. Remaining:\n";
print_r($usersDao->getAll());

echo "\n";

// Packages CRUD
echo "- PACKAGES -\n";
$package = $packagesDao->add([
    'name' => 'Premium Hair Package',
    'description' => 'Full hair care and styling',
    'price' => 99.99
]);
print_r($packagesDao->getAll());

// Read by Name
$fetchedPackage = $packagesDao->getByName('Premium Hair Package');
echo "Fetched package by Name:\n";
print_r($fetchedPackage);

// Update
$packagesDao->update(['price' => 79.99], $package['id']);
$updatedPackage = $packagesDao->getById($package['id']);
echo "Updated package price:\n";
print_r($updatedPackage);

// Get package prices
$packagePrices = $packagesDao->getPackagePrices();
echo "Package prices:\n";
print_r($packagePrices);

// Delete
$packagesDao->delete($package['id']);
echo "Deleted package. Remaining:\n";
print_r($packagesDao->getAll());

echo "\n";

// Bookings CRUD
echo "- BOOKINGS -\n";
// Re-add user and package for booking
$user = $usersDao->add([
    'first_name' => 'Selena',
    'last_name' => 'Huseinbasic',
    'email' => 'selena@example.com',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'phone' => '1234567890',
    'role' => 'user'
]);
$package = $packagesDao->add([
    'name' => 'Premium Hair Package',
    'description' => 'Full hair care and styling',
    'price' => 99.99
]);

$booking = $bookingsDao->add([
    'user_id' => $user['id'],
    'package_id' => $package['id'],
    'booking_date' => date('Y-m-d H:i:s')
]);
print_r($bookingsDao->getAll());

// Read by User ID
$userBookings = $bookingsDao->getByUserId($user['id']);
echo "Bookings by User ID:\n";
print_r($userBookings);

// Read by Package ID
$packageBookings = $bookingsDao->getByPackageId($package['id']);
echo "Bookings by Package ID:\n";
print_r($packageBookings);

// Read by Date
$dateBookings = $bookingsDao->getByDate(date('Y-m-d H:i:s', strtotime('+1 day')));
echo "Bookings by Date (should be empty for tomorrow):\n";
print_r($dateBookings);

// Update
$bookingsDao->update(['booking_date' => date('Y-m-d H:i:s', strtotime('+1 day'))], $booking['id']);
$updatedBooking = $bookingsDao->getById($booking['id']);
echo "Updated booking date:\n";
print_r($updatedBooking);

// Delete
$bookingsDao->delete($booking['id']);
echo "Deleted booking. Remaining:\n";
print_r($bookingsDao->getAll());

echo "\n";

// Contacts CRUD
echo "- CONTACTS -\n";
$contact = $contactsDao->add([
    'name' => 'Visitor',
    'email' => 'visitor@example.com',
    'phone' => '0601234567',
    'message' => 'Hello, I have a question!!'
]);
print_r($contactsDao->getAll());

// Read by Email
$fetchedContact = $contactsDao->getByEmail('visitor@example.com');
echo "Fetched contact by Email:\n";
print_r($fetchedContact);

// Update
$contactsDao->update(['message' => 'Updated message'], $contact['id']);
$updatedContact = $contactsDao->getById($contact['id']);
echo "Updated contact message:\n";
print_r($updatedContact);

// Delete
$contactsDao->delete($contact['id']);
echo "Deleted contact. Remaining:\n";
print_r($contactsDao->getAll());

echo "\n";

// Newsletter CRUD
echo "- NEWSLETTER -\n";
$newsletter = $newsletterDao->add([
    'email' => 'subscriber@example.com'
]);
print_r($newsletterDao->getAll());

// Read by Email
$fetchedNewsletter = $newsletterDao->getByEmail('subscriber@example.com');
echo "Fetched subscriber by Email:\n";
print_r($fetchedNewsletter);

// Update
$newsletterDao->update(['email' => 'subscriber.updated@example.com'], $newsletter['id']);
$updatedNewsletter = $newsletterDao->getById($newsletter['id']);
echo "Updated newsletter email:\n";
print_r($updatedNewsletter);

// Get all subscriptions
$allSubscriptions = $newsletterDao->getAllSubscriptions();
echo "All newsletter subscriptions:\n";
print_r($allSubscriptions);

// Delete
$newsletterDao->delete($newsletter['id']);
echo "Deleted newsletter subscription. Remaining:\n";
print_r($newsletterDao->getAll());

echo "\n=== TEST COMPLETE ===\n";
?>
