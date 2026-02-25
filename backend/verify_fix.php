<?php
$json = file_get_contents('http://localhost:2000/backend/api/item?id=64');
$data = json_decode($json, true);
if (isset($data['data']['caminho_imagem'])) {
    echo "ID: 64\n";
    echo "Caminho: " . $data['data']['caminho_imagem'] . "\n";
} else {
    echo "Error: Caminho not found in response.\n";
    echo $json;
}
