<?php
namespace Sebo\Alfarrabio\Core;
use Sebo\Alfarrabio\Database\Database;

class Cart
{
    private static function getUsuarioId()
    {
        return $_SESSION['usuario_id'] ?? null;
    }

    public static function add($id_item, $quantidade = 1)
    {
        $usuario_id = self::getUsuarioId();

        if ($usuario_id) {
            $db = Database::getInstance();
            // Verifica se o item já existe no carrinho do banco
            $sql = "SELECT id_carrinho, quantidade FROM tbl_carrinho WHERE id_usuario = :user AND id_item = :item";
            $stmt = $db->prepare($sql);
            $stmt->execute([':user' => $usuario_id, ':item' => $id_item]);
            $exists = $stmt->fetch();

            if ($exists) {
                $sql = "UPDATE tbl_carrinho SET quantidade = quantidade + :qty WHERE id_carrinho = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([':qty' => $quantidade, ':id' => $exists['id_carrinho']]);
            } else {
                $sql = "INSERT INTO tbl_carrinho (id_usuario, id_item, quantidade) VALUES (:user, :item, :qty)";
                $stmt = $db->prepare($sql);
                $stmt->execute([':user' => $usuario_id, ':item' => $id_item, ':qty' => $quantidade]);
            }
        } else {
            // Lógica para visitante (sessão)
            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [];
            }

            if (isset($_SESSION['carrinho'][$id_item])) {
                $_SESSION['carrinho'][$id_item]['quantidade'] += $quantidade;
            } else {
                $db = Database::getInstance();
                $sql = "SELECT id_item, titulo_item, preco_item, foto_item FROM tbl_itens WHERE id_item = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([':id' => $id_item]);
                $item = $stmt->fetch();

                if ($item) {
                    $_SESSION['carrinho'][$id_item] = [
                        'id_item' => $item['id_item'],
                        'titulo' => $item['titulo_item'],
                        'preco' => $item['preco_item'],
                        'imagem' => $item['foto_item'],
                        'quantidade' => $quantidade
                    ];
                }
            }
        }
    }

    public static function get()
    {
        $usuario_id = self::getUsuarioId();

        if ($usuario_id) {
            $db = Database::getInstance();
            $sql = "SELECT c.id_item, i.titulo_item as titulo, i.preco_item as preco, i.foto_item as imagem, c.quantidade 
                    FROM tbl_carrinho c
                    JOIN tbl_itens i ON c.id_item = i.id_item
                    WHERE c.id_usuario = :user";
            $stmt = $db->prepare($sql);
            $stmt->execute([':user' => $usuario_id]);
            $itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Mapear para o formato esperado pelo frontend se necessário
            return array_map(function ($item) {
                $item['id_item'] = (int) $item['id_item'];
                $item['preco'] = (float) $item['preco'];
                $item['preco_item'] = $item['preco']; // Compatibilidade
                $item['quantidade'] = (int) $item['quantidade'];
                return $item;
            }, $itens);
        }

        return $_SESSION['carrinho'] ?? [];
    }

    public static function update($id_item, $quantidade)
    {
        $usuario_id = self::getUsuarioId();

        if ($usuario_id) {
            $db = Database::getInstance();
            if ($quantidade <= 0) {
                self::remove($id_item);
            } else {
                $sql = "UPDATE tbl_carrinho SET quantidade = :qty WHERE id_usuario = :user AND id_item = :item";
                $stmt = $db->prepare($sql);
                $stmt->execute([':qty' => $quantidade, ':user' => $usuario_id, ':item' => $id_item]);
            }
        } else {
            if (isset($_SESSION['carrinho'][$id_item])) {
                if ($quantidade <= 0) {
                    unset($_SESSION['carrinho'][$id_item]);
                } else {
                    $_SESSION['carrinho'][$id_item]['quantidade'] = $quantidade;
                }
            }
        }
    }

    public static function remove($id_item)
    {
        $usuario_id = self::getUsuarioId();

        if ($usuario_id) {
            $db = Database::getInstance();
            $sql = "DELETE FROM tbl_carrinho WHERE id_usuario = :user AND id_item = :item";
            $stmt = $db->prepare($sql);
            $stmt->execute([':user' => $usuario_id, ':item' => $id_item]);
        } else {
            unset($_SESSION['carrinho'][$id_item]);
        }
    }

    public static function clear()
    {
        $usuario_id = self::getUsuarioId();

        if ($usuario_id) {
            $db = Database::getInstance();
            $sql = "DELETE FROM tbl_carrinho WHERE id_usuario = :user";
            $stmt = $db->prepare($sql);
            $stmt->execute([':user' => $usuario_id]);
        }

        unset($_SESSION['carrinho']);
    }

    /**
     * Sincroniza o carrinho da sessão com o banco de dados após o login
     */
    public static function sync($usuario_id)
    {
        if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
            // Temporariamente remove o ID da sessão para o add usar o id passado
            // Ou melhor, o add já vai usar o id da sessão que acabou de ser setado no AuthController
            foreach ($_SESSION['carrinho'] as $id_item => $item) {
                self::add($id_item, $item['quantidade']);
            }
            unset($_SESSION['carrinho']);
        }
    }

    public static function total()
    {
        $total = 0;
        foreach (self::get() as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }

    public static function count()
    {
        $count = 0;
        foreach (self::get() as $item) {
            $count += $item['quantidade'];
        }
        return $count;
    }
}