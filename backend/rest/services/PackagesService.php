<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PackagesDao.php';

class PackagesService extends BaseService {
    private $packagesDao;

    public function __construct() {
        $this->packagesDao = new PackagesDao();
        parent::__construct($this->packagesDao);
    }

    public function createPackage($data) {
        if (empty($data['name']) || !isset($data['price'])) {
            return ['success' => false, 'error' => 'name and price are required.'];
        }

        if (!is_numeric($data['price']) || $data['price'] < 0) {
            return ['success' => false, 'error' => 'Invalid price.'];
        }

        // optional description
        if (!isset($data['description'])) $data['description'] = null;

        // ensure unique name
        $existing = $this->packagesDao->getByName($data['name']);
        if ($existing) {
            return ['success' => false, 'error' => 'Package name already exists.'];
        }

        return $this->add([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => number_format((float)$data['price'], 2, '.', '')
        ]);
    }

    public function getPackagePrices() {
        if (method_exists($this->packagesDao, 'getPackagePrices')) {
            return ['success' => true, 'data' => $this->packagesDao->getPackagePrices()];
        }
        return $this->getAll();
    }

    public function updatePackage($id, $data) {
        if (isset($data['price'])) {
            if (!is_numeric($data['price']) || $data['price'] < 0) {
                return ['success' => false, 'error' => 'Invalid price.'];
            }
            $data['price'] = number_format((float)$data['price'], 2, '.', '');
        }
        return $this->update($data, $id);
    }
}
