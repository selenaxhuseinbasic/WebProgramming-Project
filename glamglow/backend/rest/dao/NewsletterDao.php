<?php
require_once 'BaseDao.php';

class NewsletterDao extends BaseDao {
    public function __construct() {
        parent::__construct("newsletter_subscriptions");
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM newsletter_subscriptions WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }
}
?>
