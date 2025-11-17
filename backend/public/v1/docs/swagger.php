<?php
declare(strict_types=1);

require __DIR__ . '/../../../../vendor/autoload.php';

use OpenApi\Generator;

$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../rest/routes'
]);

// This is to save swagger.json in our folder
$jsonFile = __DIR__ . '/swagger.json';
file_put_contents($jsonFile, $openapi->toJson(JSON_PRETTY_PRINT));  // Pretty-printed JSON

header('Content-Type: application/json');
echo $openapi->toJson(JSON_PRETTY_PRINT);

