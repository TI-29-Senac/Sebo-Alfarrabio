<?php
require __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Controllers\AvaliacaoClienteController;
use Sebo\Alfarrabio\Core\Session;

// Mock Session
class MockSession extends Session {
    public function get($key) {
        if ($key === 'usuario_id') return 44;
        return null;
    }
}

// Override Class to use MockSession
class TestAvaliacaoController extends AvaliacaoClienteController {
    public function __construct() {
        // Reflection to set private property if needed, but since we modify constructor...
        // Actually, I can't easily override the constructor's session instantiation without dependency injection.
        // But since I modified the code, I can't easily swap it out without changing the code again.
        // Wait, `AvaliacaoClienteController` does `new Session()`.
        
        // Strategy: Modify `AvaliacaoClienteController` temporarily or use a different approach.
        // Or, I can just populate $_SESSION if the Session class uses native PHP sessions.
        // Let's assume native sessions.
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['usuario_id'] = 44;
        
        parent::__construct();
    }
}

// Setup Environment
$_POST['id_item'] = 1;
$_POST['nota'] = 5;
$_POST['comentario'] = 'Teste de upload via script ' . date('H:i:s');

// Setup $_FILES
$_FILES['foto_avaliacao'] = [
    'name' => 'test_image.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => __DIR__ . '/test_image.jpg',
    'error' => 0,
    'size' => filesize(__DIR__ . '/test_image.jpg')
];

// Execute
ob_start(); // Capture output
try {
    $controller = new TestAvaliacaoController();
    $controller->salvarAvaliacao();
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}
$output = ob_get_clean();

echo "Output: " . $output . "\n";

// Check Database
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM tbl_avaliacao WHERE id_usuario = 44 ORDER BY id_avaliacao DESC LIMIT 1");
$av = $stmt->fetch(PDO::FETCH_ASSOC);

print_r($av);
