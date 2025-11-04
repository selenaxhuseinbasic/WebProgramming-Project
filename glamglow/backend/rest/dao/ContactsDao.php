<?php
require_once 'BaseDao.php';

class ContactsDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts");
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM contacts WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }
}
?>
