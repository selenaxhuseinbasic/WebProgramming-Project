<?php
require_once 'BaseDao.php';

class BookingsDao extends BaseDao {
    public function __construct() {
        parent::__construct("bookings");
    }

    // Get all bookings by user ID
    public function getByUserId($user_id) {
        return $this->query("SELECT * FROM {$this->table_name} WHERE user_id = :user_id", ['user_id' => $user_id]);
    }

    // Get all bookings by package
    public function getByPackageId($package_id) {
        return $this->query("SELECT * FROM {$this->table_name} WHERE package_id = :package_id", ['package_id' => $package_id]);
    }

    // Get bookings by date (date when user booked)
    public function getByDate($date) {
        return $this->query("SELECT * FROM {$this->table_name} WHERE booking_date = :date", ['date' => $date]);
    }
}
?>