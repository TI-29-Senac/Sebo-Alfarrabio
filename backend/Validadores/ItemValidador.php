<?php
namespace Sebo\Alfarrabio\Validators;

use Sebo\Alfarrabio\Models\Item;

class ItemValidator
{
    /**
     * Valida os dados de um Item antes de salvar ou atualizar.
     * 
     * @param Item $item
     * @return array Lista de erros (vazia se estiver tudo válido)
     */
    public static function validar(Item $item): array
    {
        $erros = [];

        // 🔍 Validação do nome
        if (empty(trim($item->getNome()))) {
            $erros['nome'] = 'O campo nome é obrigatório.';
        } elseif (strlen($item->getNome()) < 3) {
            $erros['nome'] = 'O nome deve ter pelo menos 3 caracteres.';
        }

        // 🔍 Validação da descrição
        if (empty(trim($item->getDescricao()))) {
            $erros['descricao'] = 'A descrição é obrigatória.';
        }

        // 🔍 Validação de preço
        if ($item->getPreco() === null || $item->getPreco() === '') {
            $erros['preco'] = 'O campo preço é obrigatório.';
        } elseif (!is_numeric($item->getPreco()) || $item->getPreco() < 0) {
            $erros['preco'] = 'O preço deve ser um número positivo.';
        }

        // 🔍 Validação de quantidade
        if ($item->getQuantidade() === null || $item->getQuantidade() === '') {
            $erros['quantidade'] = 'O campo quantidade é obrigatório.';
        } elseif (!filter_var($item->getQuantidade(), FILTER_VALIDATE_INT)) {
            $erros['quantidade'] = 'A quantidade deve ser um número inteiro.';
        } elseif ($item->getQuantidade() < 0) {
            $erros['quantidade'] = 'A quantidade não pode ser negativa.';
        }

        // 🔍 Validação de categoria (se existir no model)
        if (method_exists($item, 'getCategoriaId')) {
            if (empty($item->getCategoriaId())) {
                $erros['categoria'] = 'Selecione uma categoria válida.';
            }
        }

        return $erros;
    }
}
