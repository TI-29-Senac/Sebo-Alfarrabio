<?php
namespace Sebo\Alfarrabio\Controllers\Admin;

use Sebo\Alfarrabio\Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Verifica se está logado
        if (!isset($_SESSION['usuario_logado'])) {
            header('Location: /auth/login');
            exit;
        }

        // Busca dados do dashboard
        $dados = [
            'total_acervo' => $this->buscarTotalAcervo(),
            'total_reservas' => $this->buscarTotalReservas(),
            'vendas_mes' => $this->buscarVendasMes(),
            'faturamento_mes' => $this->buscarFaturamentoMes(),
            'ultimas_vendas' => $this->buscarUltimasVendas(),
            'reservas_ativas' => $this->buscarReservasAtivas(),
            'itens_vendidos' => $this->buscarItensVendidos(),
            'categorias' => $this->buscarCategorias()
        ];

        // Carrega a view
        $this->view('admin/dashboard', $dados);
    }

    private function buscarTotalAcervo()
    {
        $query = "SELECT COUNT(*) as total FROM tbl_acervo WHERE excluido_em IS NULL";
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    private function buscarTotalReservas()
    {
        $query = "SELECT COUNT(*) as total FROM tbl_reservas WHERE status_reserva = 'ativa' AND excluido_em IS NULL";
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    private function buscarVendasMes()
    {
        $query = "SELECT COUNT(*) as total FROM tbl_vendas 
                  WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) 
                  AND YEAR(data_venda) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    private function buscarFaturamentoMes()
    {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total FROM tbl_vendas 
                  WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) 
                  AND YEAR(data_venda) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    private function buscarUltimasVendas()
    {
        $query = "SELECT v.*, u.nome_usuario 
                  FROM tbl_vendas v
                  LEFT JOIN tbl_usuario u ON v.id_usuario = u.id_usuario
                  ORDER BY v.data_venda DESC 
                  LIMIT 5";
        return $this->db->query($query);
    }

    private function buscarReservasAtivas()
    {
        $query = "SELECT r.*, u.nome_usuario, a.titulo_acervo
                  FROM tbl_reservas r
                  LEFT JOIN tbl_usuario u ON r.id_usuario = u.id_usuario
                  LEFT JOIN tbl_acervo a ON r.id_acervo = a.id_acervo
                  WHERE r.status_reserva = 'ativa'
                  ORDER BY r.data_reserva DESC
                  LIMIT 5";
        return $this->db->query($query);
    }

    private function buscarItensVendidos()
    {
        $query = "SELECT a.titulo_acervo, COUNT(*) as total_vendas
                  FROM tbl_itens_vendas iv
                  LEFT JOIN tbl_acervo a ON iv.id_acervo = a.id_acervo
                  WHERE iv.excluido_em IS NULL
                  GROUP BY iv.id_acervo
                  ORDER BY total_vendas DESC
                  LIMIT 5";
        return $this->db->query($query);
    }

    private function buscarCategorias()
    {
        $query = "SELECT c.nome_categoria, COUNT(i.id_itens) as total
                  FROM tbl_categoria c
                  LEFT JOIN tbl_itens i ON c.id_categoria = i.id_categoria
                  WHERE c.excluido_em IS NULL
                  GROUP BY c.id_categoria
                  ORDER BY total DESC
                  LIMIT 5";
        return $this->db->query($query);
    }
}