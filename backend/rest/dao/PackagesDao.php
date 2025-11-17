<?php
require_once 'BaseDao.php';

class PackagesDao extends BaseDao {
    public function __construct() {
        parent::__construct("packages");
    }

    public function getByName($name) {
        $query = "SELECT * FROM packages WHERE name = :name";
        return $this->query_unique($query, ['name' => $name]);
    }

    // NOTE: This is a future helper to fetch only names and prices of all packages
    public function getPackagePrices() {
        $query = "SELECT id, name, price FROM packages";
        return $this->query($query);
    }
}
?>