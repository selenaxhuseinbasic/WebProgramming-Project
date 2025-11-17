<?php
require_once 'BaseDao.php';

class ContactsDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts");
    }

    // Fetch a single contact by email
    public function getByEmail($email) {
        $query = "SELECT * FROM contacts WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    // Fetch all contact submissions 
    // NOTE: This is for future dashboard where admin will have a functionality to fetch all contact messages
    public function getAllContacts() {
        return $this->getAll(); // Uses BaseDao's getAll()
    }
}
?>
