<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Database/Config.php';
require_once __DIR__ . '/../Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

/**
 * Script para atualizar preços em massa a partir de um CSV
 * Formato esperado: ISBN;Titulo;...;Valor de Venda;...
 */

$csvFile = __DIR__ . '/../uploads/update_prices.csv';

if (!file_exists($csvFile)) {
    die("Arquivo CSV não encontrado em: $csvFile\n");
}

$db = Database::getInstance();
$handle = fopen($csvFile, "r");

if ($handle === false) {
    die("Erro ao abrir o arquivo CSV.\n");
}

// Pula o cabeçalho
$header = fgetcsv($handle, 0, ";");

$processados = 0;
$atualizados = 0;
$erros = 0;

$sql = "UPDATE tbl_itens SET preco_item = :preco WHERE isbn = :isbn";
$stmt = $db->prepare($sql);

echo "Iniciando processamento...\n";

while (($data = fgetcsv($handle, 0, ";")) !== false) {
    if (count($data) < 9)
        continue;

    $isbn = trim($data[0]);
    $valorVendaRaw = trim($data[8]); // Coluna index 8: Valor de Venda

    if (empty($isbn) || $isbn === 'Não possui')
        continue;

    // Converte "R$ 50,00" -> 50.00
    $preco = str_replace(['R$', ' '], '', $valorVendaRaw);
    $preco = str_replace(',', '.', $preco);
    $preco = (float) $preco;

    if ($preco <= 0)
        continue;

    try {
        $stmt->execute([':preco' => $preco, ':isbn' => $isbn]);
        if ($stmt->rowCount() > 0) {
            $atualizados++;
        }
        $processados++;
    } catch (Exception $e) {
        echo "Erro ao atualizar ISBN $isbn: " . $e->getMessage() . "\n";
        $erros++;
    }
}

fclose($handle);

echo "Processamento concluído!\n";
echo "Total de linhas lidas: $processados\n";
echo "Total de itens atualizados: $atualizados\n";
echo "Total de erros: $erros\n";
