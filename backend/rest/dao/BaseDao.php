<?php
require_once __DIR__ . '/../../config.php';

class BaseDao {
    protected $connection;
    protected $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
        try {
            $this->connection = new PDO(
                "mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";port=" . Config::DB_PORT(),
                Config::DB_USER(),
                Config::DB_PASSWORD(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params = []) {
        $results = $this->query($query, $params);
        return reset($results);
    }

    public function getAll() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['success' => true, 'data' => $results];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name . " WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return ['success' => true, 'data' => $result];
            } else {
                return ['success' => false, 'error' => $this->table_name . " record not found"];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function add($entity) {
        try {
            $columns = implode(", ", array_keys($entity));
            $placeholders = ":" . implode(", :", array_keys($entity));
            $sql = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($entity);
            $entity['id'] = $this->connection->lastInsertId();
            return ['success' => true, 'data' => $entity];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($entity, $id) {
        try {
            $fields = "";
            foreach ($entity as $key => $value) {
                $fields .= "$key = :$key, ";
            }
            $fields = rtrim($fields, ", ");
            $sql = "UPDATE " . $this->table_name . " SET $fields WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $entity['id'] = $id;
            $stmt->execute($entity);
            return ['success' => true, 'data' => $entity];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ['success' => true, 'data' => ['id' => $id]];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
