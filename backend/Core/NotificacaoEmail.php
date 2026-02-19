<?php
namespace Sebo\Alfarrabio\Core;
use Sebo\Alfarrabio\Core\EmailService;
 
class NotificacaoEmail
{
    private $emailService;
    private $urlBase;
 
    public function __construct()
    {
        $this->emailService = new EmailService();
        // Define a URL base do projeto
        $this->urlBase = "http://localhost:4000";
        // Para produção, você pode usar:
        // $this->urlBase = "https://www.sebo-alfarrabio.com.br";
    }
 
    /**
     * Envia email de redefinição de senha.
     * @param string $email
     * @param string $token
     */
    public function esqueciASenha(string $email, string $token): void
    {
        $assunto = "Redefinição de Senha";
        $mensagem = "Clique no link para redefinir sua senha: ";
        $mensagem .= $this->urlBase . "/backend/redefinir-senha?token=" . urlencode($token);
        $this->emailService->send($email, $assunto, $mensagem);
    }
 
    /**
     * Envia email de boas-vindas.
     * @param string $email
     * @param string $nome
     */


        ///////////// EMAIL DE BOAS-VINDAS ////////////
    public function boasVindas(string $email, string $nome): void
    {
        $assunto = "Bem-vindo ao Sebo-Alfarrabio!";
 
        $mensagem = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Georgia", "Times New Roman", serif;
            background-color: #f5f1e8;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 2px solid #8b4513;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #6b4423 0%, #8b4513 100%);
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #d4a574;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
        }
        .header h1 {
            margin: 0;
            color: #f5deb3;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .content {
            padding: 40px 30px;
            background-color: #fefdfb;
            color: #3e2723;
            line-height: 1.8;
        }
        .greeting {
            font-size: 22px;
            color: #6b4423;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .message {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .highlight {
            background-color: #fff8dc;
            padding: 20px;
            border-left: 4px solid #8b4513;
            margin: 25px 0;
            border-radius: 4px;
        }
        .highlight p {
            margin: 8px 0;
            color: #5d4037;
        }
        .footer {
            background-color: #f5f1e8;
            padding: 25px;
            text-align: center;
            border-top: 2px solid #d4a574;
            color: #6b4423;
            font-size: 14px;
        }
        .signature {
            font-style: italic;
            color: #6b4423;
            margin-top: 30px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="' . $this->urlBase . '/img/logo2.png" alt="Logo Sebo-Alfarrabio" class="logo">
            <h1>Sebo-Alfarrabio</h1>
        </div>
       
        <div class="content">
            <p class="greeting">👋 Olá, ' . htmlspecialchars($nome) . '!</p>
           
            <p class="message">
                É com grande alegria que damos as boas-vindas a você em nossa comunidade de amantes de livros raros e histórias inesquecíveis.
            </p>
           
            <p class="message">
                O <strong>Sebo-Alfarrabio</strong> é mais do que um simples sebo online – é um refúgio para aqueles que acreditam que cada livro guarda segredos, memórias e conhecimentos que merecem ser redescobertos.
            </p>
           
            <div class="highlight">
                <p><strong>🔖 O que você pode fazer agora:</strong></p>
                <p>• Explorar nosso acervo de livros únicos e raros</p>
                <p>• Adicionar obras à sua lista de desejos</p>
                <p>• Acompanhar novidades e lançamentos</p>
            </div>
           
            <p class="message">
                Estamos aqui para ajudá-lo a encontrar aquele livro especial que você tanto procura, ou quem sabe apresentar uma obra que você nem sabia que precisava ler.
            </p>
           
            <p class="signature">
                Boas leituras e ótimas descobertas!<br>
                <strong>Equipe Sebo-Alfarrabio ❤️📖</strong>
            </p>
        </div>
       
        <div class="footer">
            <p>📖 <em>"Cada livro é uma viagem, cada página uma nova descoberta"</em></p>
            <p style="margin-top: 15px; font-size: 12px; color: #8b4513;">
                Este é um e-mail automático. Por favor, não responda.
            </p>
        </div>
    </div>
</body>
</html>
';
        $this->emailService->send($email, $assunto, $mensagem);
    }
    ////////////////////////////////////////////////
 
 
 
 
 
 
 
///////////////////// EMAIL DE RESERVA RECEBIDA /////////////////////
   
    /**
     * Envia email de confirmação de reserva.
     * @param array $usuario Dados do usuário (nome, email).
     * @param array $pedido Dados do pedido (id, valor_total, itens).
     */
    public function enviarConfirmacaoReserva(array $usuario, array $pedido): void
    {
        $nome = $usuario['nome_usuario'];
        $email = $usuario['email_usuario'];
        $idPedido = $pedido['id'];
        $total = number_format($pedido['valor_total'], 2, ',', '.');
       
        $assunto = "Reserva #{$idPedido} Recebida - Sebo-Alfarrabio";
 
        $itensHtml = '';
        foreach ($pedido['itens'] as $item) {
            $itensHtml .= "<li>{$item['quantidade']}x {$item['titulo']}</li>";
        }
 
        $mensagem = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Georgia", "Times New Roman", serif;
            background-color: #f5f1e8;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 2px solid #8b4513;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #6b4423 0%, #8b4513 100%);
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #d4a574;
        }
        .header h1 {
            margin: 0;
            color: #f5deb3;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .content {
            padding: 40px 30px;
            background-color: #fefdfb;
            color: #3e2723;
            line-height: 1.8;
        }
        .greeting {
            font-size: 22px;
            color: #6b4423;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .message {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .pedido-info {
            background-color: #fff8dc;
            padding: 20px;
            border-left: 4px solid #8b4513;
            margin: 25px 0;
            border-radius: 4px;
        }
        .pedido-info p {
            margin: 8px 0;
            color: #5d4037;
        }
        .footer {
            background-color: #f5f1e8;
            padding: 25px;
            text-align: center;
            border-top: 2px solid #d4a574;
            color: #6b4423;
            font-size: 14px;
        }
        .signature {
            font-style: italic;
            color: #6b4423;
            margin-top: 30px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🕐 Reserva Recebida!</h1>
        </div>
        <div class="content">
            <p class="greeting">👋 Olá, ' . htmlspecialchars($nome) . '!</p>

            <p class="message">
                Sua solicitação de reserva foi recebida com sucesso e está <strong>aguardando confirmação</strong> de nossa equipe.
            </p>
            <p class="message">
                Em breve analisaremos seu pedido e você receberá uma notificação quando a reserva for confirmada.
            </p>
           
            <div class="pedido-info">
                <p><strong>Número do Pedido:</strong> #' . $idPedido . '</p>
                <p><strong>Status:</strong> <span style="color: #8b4513; font-weight: bold;">Pendente</span></p>
                <p><strong>Valor Total:</strong> R$ ' . $total . '</p>
                <p><strong>Itens:</strong></p>
                <ul>' . $itensHtml . '</ul>
            </div>
           
            <p class="message">
                Nossa equipe irá verificar a disponibilidade dos itens e confirmar sua reserva. Você receberá um e-mail assim que o status for atualizado.
            </p>
           
            <p class="signature">
                Atenciosamente,<br>
                <strong>Equipe Sebo-Alfarrabio ❤️📖</strong>
            </p>
        </div>
        <div class="footer">
            <p>📖 <em>"Cada livro é uma viagem, cada página uma nova descoberta"</em></p>
            <p style="margin-top: 15px; font-size: 12px; color: #8b4513;">
                Este é um e-mail automático. Por favor, não responda.
            </p>
        </div>
    </div>
</body>
</html>
';
        $this->emailService->send($email, $assunto, $mensagem);
    }
    /////////////////////////////////////////////////////////////
 
 
 
 
 
   
    /**
     * Envia email de confirmação de reserva APROVADA pelo funcionário.
     * @param array $usuario Dados do usuário (nome, email).
     * @param array $pedido Dados do pedido (id, valor_total, itens).
     */
    public function enviarReservaAprovada(array $usuario, array $pedido): void
    {
        $nome = $usuario['nome_usuario'];
        $email = $usuario['email_usuario'];
        $idPedido = $pedido['id_pedidos'] ?? $pedido['id'];
        $total = number_format($pedido['valor_total'], 2, ',', '.');
       
        $assunto = "Sua Reserva #{$idPedido} foi Aprovada! - Sebo-Alfarrabio";
 
        $itensHtml = '';
        if (isset($pedido['itens']) && is_array($pedido['itens'])) {
            foreach ($pedido['itens'] as $item) {
                $titulo = $item['titulo_item'] ?? $item['titulo'] ?? 'Item';
                $itensHtml .= "<li>{$item['quantidade']}x {$titulo}</li>";
            }
        }
 
        $mensagem = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Georgia", "Times New Roman", serif;
            background-color: #f5f1e8;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 2px solid #8b4513;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #6b4423 0%, #8b4513 100%);
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #d4a574;
        }
        .header h1 {
            margin: 0;
            color: #f5deb3;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .content {
            padding: 40px 30px;
            background-color: #fefdfb;
            color: #3e2723;
            line-height: 1.8;
        }
        .greeting {
            font-size: 22px;
            color: #6b4423;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .message {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .pedido-info {
            background-color: #fff8dc;
            padding: 20px;
            border-left: 4px solid #8b4513;
            margin: 25px 0;
            border-radius: 4px;
        }
        .pedido-info p {
            margin: 8px 0;
            color: #5d4037;
        }
        .aviso {
            background-color: #fdf3e3;
            border: 1px solid #d4a574;
            border-left: 4px solid #8b4513;
            border-radius: 4px;
            padding: 18px 20px;
            margin: 25px 0;
            color: #5d4037;
            font-size: 15px;
            line-height: 1.7;
        }
        .aviso p {
            margin: 6px 0;
        }
        .aviso strong {
            color: #6b4423;
        }
        .footer {
            background-color: #f5f1e8;
            padding: 25px;
            text-align: center;
            border-top: 2px solid #d4a574;
            color: #6b4423;
            font-size: 14px;
        }
        .signature {
            font-style: italic;
            color: #6b4423;
            margin-top: 30px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✔ Reserva Aprovada!</h1>
        </div>

        <div class="content">
            <p class="greeting">👋 Olá, ' . htmlspecialchars($nome) . '!</p>

            <p class="message">
                Boas notícias! Sua reserva foi analisada e <strong>aprovada</strong> por nossa equipe. Seus livros já estão separados e aguardando por você.
            </p>

            <div class="pedido-info">
                <p><strong>Número do Pedido:</strong> #' . $idPedido . '</p>
                <p><strong>Status:</strong> <span style="color: #8b4513; font-weight: bold;">Reservado ✔</span></p>
                <p><strong>Valor Total:</strong> R$ ' . $total . '</p>
                <p><strong>Itens reservados:</strong></p>
                <ul>' . $itensHtml . '</ul>
            </div>

            <div class="aviso">
                <p>⚠️ <strong>Atenção:</strong> Você tem até <strong>5 dias corridos</strong> para comparecer à loja e retirar sua reserva.</p>
                <p>Caso o prazo não seja cumprido, o pedido será <strong>automaticamente cancelado</strong> e os itens voltarão ao acervo.</p>
            </div>

            <p class="message">
                Em caso de dúvidas ou se precisar de mais informações, entre em contato conosco o quanto antes.
            </p>

            <p class="signature">
                Até breve e boas leituras!<br>
                <strong>Equipe Sebo-Alfarrabio ❤️📖</strong>
            </p>
        </div>

        <div class="footer">
            <p>📖 <em>"Cada livro é uma viagem, cada página uma nova descoberta"</em></p>
            <p style="margin-top: 15px; font-size: 12px; color: #8b4513;">
                Este é um e-mail automático. Por favor, não responda.
            </p>
        </div>
    </div>
</body>
</html>
';
        $this->emailService->send($email, $assunto, $mensagem);
    }
}