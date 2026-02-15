<?php
namespace Sebo\Alfarrabio\Validadores;

class PedidosValidador
{
    /**
     * Valida dados de entrada para Pedidos.
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['data_pedido']) && empty($dados['data_pedido'])) {
            $erros[] = "O campo do pedido é obrigatório.";
        }
        if (isset($dados['status_pedido']) && empty($dados['status_pedido'])) {
            $erros[] = "O campo do pedido é obrigatório.";
        }

        return $erros;
    }
}
