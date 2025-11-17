<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookingsDao.php';
require_once __DIR__ . '/../dao/UsersDao.php';
require_once __DIR__ . '/../dao/PackagesDao.php';

class BookingsService extends BaseService {
    private $bookingsDao;
    private $usersDao;
    private $packagesDao;

    public function __construct() {
        $this->bookingsDao = new BookingsDao();
        $this->usersDao = new UsersDao();
        $this->packagesDao = new PackagesDao();
        parent::__construct($this->bookingsDao);
    }

    public function createBooking($data) {
        if (empty($data['user_id']) || empty($data['package_id']) || empty($data['booking_date'])) {
            return ['success' => false, 'error' => 'user_id, package_id and booking_date are required.'];
        }

        // Check if user exists
        $user = $this->usersDao->getById($data['user_id']);
        if (!$user) return ['success' => false, 'error' => 'User does not exist.'];

        // Check if package exists
        $package = $this->packagesDao->getById($data['package_id']);
        if (!$package) return ['success' => false, 'error' => 'Package does not exist.'];

        // Validate datetime 
        $ts = strtotime($data['booking_date']);
        if ($ts === false) return ['success' => false, 'error' => 'Invalid booking_date format.'];

        return $this->add([
            'user_id' => $data['user_id'],
            'package_id' => $data['package_id'],
            'booking_date' => date('Y-m-d H:i:s', $ts)
        ]);
    }

    // Allow fetching bookings by user
    public function getByUser($user_id) {
        try {
            return ['success' => true, 'data' => $this->bookingsDao->getByUserId($user_id)];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
