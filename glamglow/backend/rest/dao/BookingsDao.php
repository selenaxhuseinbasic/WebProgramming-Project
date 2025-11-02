<?php
require_once 'BaseDao.php';

class BookingsDao extends BaseDao {
    public function __construct() {
        parent::__construct("bookings");
    }
}
?>
