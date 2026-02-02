<?php
// Mock GET request
$_GET = [];

// Output buffering to catch unexpected output
ob_start();

require_once __DIR__ . '/backend/Core/Env.php';
require_once __DIR__ . '/backend/Database/Config.php';
require_once __DIR__ . '/backend/Database/Database.php';
require_once __DIR__ . '/backend/Models/Item.php';
require_once __DIR__ . '/backend/Models/Avaliacao.php';
require_once __DIR__ . '/backend/Controllers/PublicApiController.php';

// Carrega variáveis de ambiente
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/backend');

use Sebo\Alfarrabio\Controllers\PublicApiController;

try {
    $controller = new PublicApiController();
    $controller->getItem();
} catch (Throwable $e) {
    echo "FATAL ERROR: " . $e->getMessage() . " on line " . $e->getLine() . " of " . $e->getFile();
}

$output = ob_get_clean();
echo "--- RAW OUTPUT START ---\n";
echo $output;
echo "\n--- RAW OUTPUT END ---\n";

// Try decoding
$json = json_decode($output, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo "VALID JSON.\n";
    print_r($json);
} else {
    echo "INVALID JSON: " . json_last_error_msg() . "\n";
}
