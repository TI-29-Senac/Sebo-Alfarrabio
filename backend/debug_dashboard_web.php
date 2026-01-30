<?php
// backend/debug_dashboard_web.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tenta localizar o autoloader
$paths = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'
];

$autoloaderFound = false;
foreach ($paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        echo "Autoloader carregado de: $path<br>";
        $autoloaderFound = true;
        break;
    }
}

if (!$autoloaderFound) {
    die("ERRO: Autoloader não encontrado. Verifique se 'vendor/autoload.php' existe.");
}

// Carrega configurações
require_once __DIR__ . '/Database/Config.php';
require_once __DIR__ . '/Database/Database.php';

session_start();
echo "<h3>Diagnóstico do Dashboard</h3>";
echo "<pre><strong>SESSÃO ATUAL:</strong>\n";
print_r($_SESSION);
echo "</pre>";

use Sebo\Alfarrabio\Controllers\DashboardController;

try {
    echo "1. Tentando instanciar DashboardController...<br>";
    $controller = new DashboardController();
    echo "2. Controller instanciado com sucesso.<br>";

    echo "3. Chamando método index()...<br>";
    // Buffer para capturar o HTML da view e não renderizar tudo na tela de debug bagunçada
    ob_start();
    $controller->index();
    $html = ob_get_clean();

    echo "4. Método index() executado com sucesso.<br>";
    echo "5. Tamanho do HTML gerado: " . strlen($html) . " bytes.<br>";
    echo "<strong>STATUS: O Dashboard parece estar funcionando tecnicamente no backend.</strong>";

} catch (Throwable $e) {
    echo "<div style='background-color: #ffcccc; padding: 10px; border: 1px solid red;'>";
    echo "<h3>❌ ERRO DETECTADO:</h3>";
    echo "<strong>Mensagem:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Arquivo:</strong> " . $e->getFile() . " (Linha " . $e->getLine() . ")<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}
