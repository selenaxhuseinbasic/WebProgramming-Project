<?php
class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    protected function wrap($result) {
        if (is_array($result) && array_key_exists('success', $result)) {
            return $result;
        }
        return ['success' => true, 'data' => $result];
    }

    public function getAll() {
        try {
            return $this->wrap($this->dao->getAll());
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getById($id) {
        try {
            $result = $this->dao->getById($id);
            if (!$result['success']) return $result; 
            return ['success' => true, 'data' => $result['data']]; 
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    

    public function add($entity) {
        try {
            $result = $this->dao->add($entity);
            if (!$result['success']) return $result;
            return ['success' => true, 'data' => $result['data']]; 
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    

    public function update($entity, $id) {
        try {
            $result = $this->dao->update($entity, $id);
            if (!$result['success']) return $result;
            return ['success' => true, 'data' => $result['data']];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    

    public function delete($id) {
        try {
            $result = $this->dao->delete($id);
            if (!$result['success']) return $result;
            return ['success' => true, 'data' => ['deleted' => true, 'id' => $result['data']['id']]];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
}