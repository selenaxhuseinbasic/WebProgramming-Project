<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

// SERVICES
require_once __DIR__ . '/rest/services/UsersService.php';
require_once __DIR__ . '/rest/services/PackagesService.php';
require_once __DIR__ . '/rest/services/BookingsService.php';
require_once __DIR__ . '/rest/services/ContactsService.php';
require_once __DIR__ . '/rest/services/NewsletterService.php';

Flight::register('usersService', 'UsersService');
Flight::register('packagesService', 'PackagesService');
Flight::register('bookingsService', 'BookingsService');
Flight::register('contactsService', 'ContactsService');
Flight::register('newsletterService', 'NewsletterService');

// ROUTES
require_once __DIR__ . '/rest/routes/UsersRoutes.php';
require_once __DIR__ . '/rest/routes/PackagesRoutes.php';
require_once __DIR__ . '/rest/routes/BookingsRoutes.php';
require_once __DIR__ . '/rest/routes/ContactsRoutes.php';
require_once __DIR__ . '/rest/routes/NewsletterRoutes.php';

Flight::start();

