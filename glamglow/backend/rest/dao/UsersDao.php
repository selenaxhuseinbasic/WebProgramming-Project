<?php
require_once 'BaseDao.php';

class UsersDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }
}
?>

