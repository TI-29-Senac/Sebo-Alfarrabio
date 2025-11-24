<?php
if (!isset($_POST['id_autor'])) {
    header("Location: /backend/autor");
    exit;
}

$id = intval($_POST['id_autor']);

require_once '../database/conexao.php';

$stmt = $conn->prepare("DELETE FROM autores WHERE id_autor = ?");
$stmt->execute([$id]);

header("Location: /backend/autor");
exit;
?>
