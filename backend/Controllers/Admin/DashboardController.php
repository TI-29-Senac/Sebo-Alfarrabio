<?php
namespace Sebo\Alfarrabio\Controllers\Admin;

use Sebo\Alfarrabio\Core\View;

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Controllers\Admin\AdminController;

class DashboardController extends AdminController
{
    private $db;
     private $categoriaModel;
     private $itemModel;
     protected $session;

private function __construct() {
    parent::_construct();
        $this->db = Database::getInstance();
        $this->session = new Session();
        $this->categoriaModel = new Categoria($this->db);
        $this->itemModel = new Item($this->db);
}

    public function index(): void{
       

        // Estatísticas simples
        $totalCategorias = (int) $this->categoriaModel->totalDeCategorias();
        $totalCategoriasInativas = (int) $this->categoriaModel->totalDeCategoriasInativas();
        $totalItens = (int)$this->itemModel->totalDeItens();
        $totalItensInativos = (int) $this->itemModel->totalDeItensInativos();

        // Vendas e faturamento (se as tabelas existirem)
        try {
            $stmtVendas = $this->db->query("SELECT COUNT(*) FROM tbl_vendas WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) AND YEAR(data_venda) = YEAR(CURRENT_DATE())");
            $vendasMes = (int) $stmtVendas->fetchColumn();

            $stmtFaturamento =$this->db->query("SELECT COALESCE(SUM(valor_total),0) FROM tbl_vendas WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) AND YEAR(data_venda) = YEAR(CURRENT_DATE())");
            $faturamentoMes = (float) $stmtFaturamento->fetchColumn();
        } catch (\Throwable $e) {
            // Se não houver tabela de vendas, definimos 0 para não quebrar a página
            $vendasMes = 0;
            $faturamentoMes = 0.0;
        }

        // Últimos itens cadastrados (5)
        $ultimosItens = $this->itemModel->paginacao(1, 5)['data'];

        // Preparar dados para gráficos (últimos N meses, padrão 6)
        $period = isset($_GET['period']) ? (int) $_GET['period'] : 6;
        $allowed = [3, 6, 12];
        if (!in_array($period, $allowed)) {
            $period = 6;
        }

        $vendas_chart_labels = [];
        $vendas_chart_data = [];
        $reservas_chart_labels = [];
        $reservas_chart_data = [];

        try {
            // consulta agrupada para vendas dos últimos N meses
            $sqlVendas = "SELECT YEAR(data_venda) as yr, MONTH(data_venda) as m, COUNT(*) as total
                          FROM tbl_vendas
                          WHERE data_venda >= DATE_SUB(CURRENT_DATE(), INTERVAL " . ($period - 1) . " MONTH)
                          GROUP BY yr, m";
            $stmt = $this->db->query($sqlVendas);
            $vendasMap = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $vendasMap[ sprintf('%04d-%02d', $row['yr'], $row['m']) ] = (int) $row['total'];
            }

            // consulta agrupada para reservas dos últimos N meses
            $sqlReservas = "SELECT YEAR(data_reserva) as yr, MONTH(data_reserva) as m, COUNT(*) as total
                          FROM tbl_reservas
                          WHERE data_reserva >= DATE_SUB(CURRENT_DATE(), INTERVAL " . ($period - 1) . " MONTH)
                          GROUP BY yr, m";
            $stmt2 = $this->db->query($sqlReservas);
            $reservasMap = [];
            while ($row = $stmt2->fetch(\PDO::FETCH_ASSOC)) {
                $reservasMap[ sprintf('%04d-%02d', $row['yr'], $row['m']) ] = (int) $row['total'];
            }

            // meses em português abreviados
            $pt_months = [
                '01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr',
                '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago',
                '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'
            ];

            for ($i = $period - 1; $i >= 0; $i--) {
                $time = strtotime("-{$i} months");
                $monthNum = date('m', $time);
                $label = $pt_months[$monthNum] . '/' . date('Y', $time);
                $key = date('Y-m', $time);
                $vendas_chart_labels[] = $label;
                $vendas_chart_data[] = isset($vendasMap[$key]) ? $vendasMap[$key] : 0;
                $reservas_chart_labels[] = $label;
                $reservas_chart_data[] = isset($reservasMap[$key]) ? $reservasMap[$key] : 0;
            }
        } catch (\Throwable $e) {
            // Se não houver tabelas ou ocorrer erro, mantemos arrays vazios/zeros
            $vendas_chart_labels = [];
            $vendas_chart_data = [];
            $reservas_chart_labels = [];
            $reservas_chart_data = [];
        }

        View::render('admin/dashboard/index', [
            'nomeUsuario' => $this->session->get('usuario_nome'),
            'Tipo' => $this->session->get('usuario_tipo'),
            'totalCategorias' => $totalCategorias,
            'totalCategoriasInativas' => $totalCategoriasInativas,
            'totalItens' => $totalItens,
            'totalItensInativos' => $totalItensInativos,
            'vendasMes' => $vendasMes,
            'faturamentoMes' => $faturamentoMes,
            'ultimosItens' => $ultimosItens
            ,
            'vendas_chart_labels' => $vendas_chart_labels,
            'vendas_chart_data' => $vendas_chart_data,
            'reservas_chart_labels' => $reservas_chart_labels,
            'reservas_chart_data' => $reservas_chart_data

        ]);
    }
}