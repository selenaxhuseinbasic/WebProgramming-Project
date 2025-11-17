<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UsersDao();
        parent::__construct($this->userDao);
    }

    public function createUser($data) {
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password'])) {
            return ['success' => false, 'error' => 'first_name, last_name, email and password are required.'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }

        $existing = $this->userDao->getByEmail($data['email']);
        if ($existing) return ['success' => false, 'error' => 'Email already exists.'];

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        if (!isset($data['role'])) $data['role'] = 'user';
        if (!isset($data['phone'])) $data['phone'] = '';

        return $this->add($data);
    }

    public function updateUser($id, $data) {
        if (isset($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email format.'];
            }
            $existing = $this->userDao->getByEmail($data['email']);
            if ($existing && $existing['id'] != $id) {
                return ['success' => false, 'error' => 'Email already used by another user.'];
            }
        }

        if (isset($data['password'])) {
            if ($data['password'] === '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }
        }

        return $this->update($data, $id);
    }

    public function updateProfile($id, $data) {
        if (method_exists($this->userDao, 'updateProfile')) {
            try {
                $ok = $this->userDao->updateProfile($id, $data);
                if ($ok) return ['success' => true, 'data' => ['id' => $id]];
                return ['success' => false, 'error' => 'Nothing was updated or update failed.'];
            } catch (\Exception $e) {
                return ['success' => false, 'error' => $e->getMessage()];
            }
        } else {
            return $this->updateUser($id, $data);
        }
    }

    public function getByEmail($email) {
        try {
            $user = $this->userDao->getByEmail($email);
            if (!$user) return ['success' => false, 'error' => 'Not found'];
            return ['success' => true, 'data' => $user];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function deleteUser($id) {
        try {
            $result = $this->delete($id); // calls BaseService->delete
            $deleted = isset($result['data']['id']) ? true : false;
            return ['success' => true, 'data' => ['deleted' => $deleted]];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function patchUser($id, $data) {
        try {
            $success = $this->userDao->updateProfile($id, $data);
            if ($success) {
                return ['success' => true, 'data' => $this->getById($id)['data']];
            } else {
                return ['success' => false, 'error' => 'Failed to update user'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
