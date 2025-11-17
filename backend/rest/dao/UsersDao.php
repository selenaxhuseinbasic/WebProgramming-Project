<?php
require_once 'BaseDao.php';

class UsersDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    // Fetch user by email (for login or validation)
    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    // Update user profile info (from modal)
    public function updateProfile($id, $data) {
        // Only update allowed fields
        $fields = [];
        $params = [];
        if (isset($data['first_name'])) {
            $fields[] = "first_name = :first_name";
            $params['first_name'] = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $fields[] = "last_name = :last_name";
            $params['last_name'] = $data['last_name'];
        }
        if (isset($data['email'])) {
            $fields[] = "email = :email";
            $params['email'] = $data['email'];
        }
        if (isset($data['phone'])) {
            $fields[] = "phone = :phone";
            $params['phone'] = $data['phone'];
        }
        if (isset($data['password']) && $data['password'] !== '') {
            $fields[] = "password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (empty($fields)) {
            return false; 
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
        $params['id'] = $id;
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }
}
?>

