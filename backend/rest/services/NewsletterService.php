<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/NewsletterDao.php';

class NewsletterService extends BaseService {
    private $newsletterDao;

    public function __construct() {
        $this->newsletterDao = new NewsletterDao();
        parent::__construct($this->newsletterDao);
    }

    public function subscribe($data) {
        if (empty($data['email'])) {
            return ['success' => false, 'error' => 'email is required.'];
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }

        $existing = $this->newsletterDao->getByEmail($data['email']);
        if ($existing) {
            return ['success' => false, 'error' => 'Email already subscribed.'];
        }

        return $this->add(['email' => $data['email']]);
    }

    public function getAllSubscriptions() {
        if (method_exists($this->newsletterDao, 'getAllSubscriptions')) {
            return ['success' => true, 'data' => $this->newsletterDao->getAllSubscriptions()];
        }
        return $this->getAll();
    }
}
