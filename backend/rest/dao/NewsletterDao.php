<?php
require_once 'BaseDao.php';

class NewsletterDao extends BaseDao {
    public function __construct() {
        parent::__construct("newsletter_subscriptions");
    }

    // Fetch a single subscriber by email
    public function getByEmail($email) {
        $query = "SELECT * FROM newsletter_subscriptions WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    // Fetch all newsletter subscribers
    // NOTE: A functionality on admin dashboard will allow fetching by clicking on a button
    public function getAllSubscriptions() {
        return $this->getAll();
    }
}
?>