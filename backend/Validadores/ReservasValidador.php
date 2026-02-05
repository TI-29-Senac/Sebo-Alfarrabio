<?php
namespace Sebo\Alfarrabio\Validadores;

class ReservasValidador
{
    /**
     * Valida dados de entrada para Reservas.
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['data_reserva']) && empty($dados['data_reserva'])) {
            $erros[] = "O campo data é obrigatório.";
        }
        if (isset($dados['status_reserva']) && empty($dados['status_reserva'])) {
            $erros[] = "O campo status é obrigatório.";
        }

        return $erros;
    }
}