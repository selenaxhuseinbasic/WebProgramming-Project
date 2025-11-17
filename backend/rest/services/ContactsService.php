<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ContactsDao.php';

class ContactsService extends BaseService {
    private $contactsDao;

    public function __construct() {
        $this->contactsDao = new ContactsDao();
        parent::__construct($this->contactsDao);
    }

    public function createContact($data) {
        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            return ['success' => false, 'error' => 'name, email and message are required.'];
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }

        if (!isset($data['phone'])) $data['phone'] = '';

        $result = $this->add($data);

        if (!isset($result['success'])) {
            return ['success'=>true, 'data'=>$result];
        }
        return $result;
    }

    public function getAllContacts() {
        try {
            $contacts = $this->contactsDao->getAllContacts();
            return ['success' => true, 'data' => $contacts];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
