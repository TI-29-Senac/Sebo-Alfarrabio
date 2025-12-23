<?php
namespace Sebo\Alfarrabio\Core;

class Cart {
    public static function add($id_item, $quantidade = 1) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$id_item])) {
            $_SESSION['carrinho'][$id_item]['quantidade'] += $quantidade;
        } else {
            // Busca dados do item no banco
            $db = \Sebo\Alfarrabio\Database\Database::getInstance();
            $sql = "SELECT id_item, titulo, preco, imagem FROM tbl_itens WHERE id_item = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id_item]);
            $item = $stmt->fetch();

            if ($item) {
                $_SESSION['carrinho'][$id_item] = [
                    'id_item' => $item['id_item'],
                    'titulo' => $item['titulo'],
                    'preco' => $item['preco'],
                    'imagem' => $item['imagem'],
                    'quantidade' => $quantidade
                ];
            }
        }
    }

    public static function get() {
        return $_SESSION['carrinho'] ?? [];
    }

    public static function update($id_item, $quantidade) {
        if (isset($_SESSION['carrinho'][$id_item])) {
            if ($quantidade <= 0) {
                unset($_SESSION['carrinho'][$id_item]);
            } else {
                $_SESSION['carrinho'][$id_item]['quantidade'] = $quantidade;
            }
        }
    }

    public static function remove($id_item) {
        unset($_SESSION['carrinho'][$id_item]);
    }

    public static function clear() {
        unset($_SESSION['carrinho']);
    }

    public static function total() {
        $total = 0;
        foreach (self::get() as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }

    public static function count() {
        $count = 0;
        foreach (self::get() as $item) {
            $count += $item['quantidade'];
        }
        return $count;
    }
}