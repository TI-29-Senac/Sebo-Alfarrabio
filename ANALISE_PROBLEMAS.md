# 🔍 Análise de Erros - Round 2 (Pós-Correções Iniciais)

Esta análise foca em problemas de segunda camada, inconsistências de API e falhas de lógica remanescentes após as correções críticas de crash.

---

## 🟠 Erros de Rotas e Controladores Inexistentes

### 1. **Rotas Fantasmas (Broken Links)**
**Arquivo:** `backend/Rotas/Rotas.php`
**Problema:**
- `/produtos` e `/produtos/{pagina}` apontam para `Public\PublicItemController`.
- **Fato:** A classe `PublicItemController` **não existe** no projeto. O catálogo público provavelmente está quebrado ou inacessível.
- `/api/buscaitem` aponta para `APIItemController@getItem`.
- **Fato:** O método correto na classe é `listarItens`.

### 2. **Inconsistência de Nomenclatura (Typo)**
**Arquivo:** `backend/Controllers/APIUsarioController.php`
**Problema:** O nome do arquivo e da classe possuem um erro de digitação (`APIUsarioController` em vez de `APIUsuarioController`). Isso causa confusão na manutenção e possíveis erros de autoloading se não forem referenciados exatamente com o erro.

---

## 🛡️ Segurança e APIs

### 3. **Lógica Inversa na Validação de API (Bug Crítico de Acesso)**
**Arquivo:** `backend/Controllers/APIUsarioController.php` (Linha 16)
**Problema:**
```php
if ($this->buscaChaveAPI()) { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => 'Chave API inválida.']); 
}
```
A função `buscaChaveAPI()` retorna `true` quando o token é **VÁLIDO**. Portanto, o código acima bloqueia o acesso justamente quando o usuário fornece a chave correta.

### 4. **Ausência de Proteção CSRF**
Nenhum formulário ou rota `POST` possui proteção Cross-Site Request Forgery. Isso permite que sites mal-intencionados executem ações em nome do usuário logado (ex: deletar itens, alterar senhas).

### 5. **Bypass de Validados em Cadastro**
**Arquivo:** `backend/Controllers/AuthController.php` (Linha 65)
A validação de e-mail e senha continua comentada. O sistema aceita qualquer entrada no cadastro de novos usuários.

---

## 🧹 Manutenção e Code Smells

### 6. **Clutter de Logs de Debug**
**Arquivo:** `backend/Controllers/VendasController.php`
O arquivo está saturado com chamadas `error_log` que poluem o log do servidor em produção.

### 7. **Redundância de Controladores de API**
`PublicApiController` e `APIItemController` possuem métodos que fazem quase a mesma coisa, mas com implementações diferentes (um usa `Item::corrigirCaminhoImagem`, o outro não). Isso gera desvios de comportamento entre o site e a API.

### 8. **Inconsistência em Soft Delete**
O modelo `Vendas` não filtra consistentemente registros por `excluido_em IS NULL` em todos os métodos de busca (ex: `buscarVendasPorID`), permitindo a visualização de dados teoricamente deletados.

---

## 📋 Próximas Prioridades de Correção

1. **🔴 URGENTE:** Corrigir as rotas de `/produtos` para apontar para o controlador correto (ou criar o controlador faltante).
2. **🔴 URGENTE:** Inverter a lógica de validação da `APIUsuarioController`.
3. **🟠 ALTO:** Implementar um middleware ou helper para proteção CSRF.
4. **🟠 ALTO:** Unificar os controladores de API (`PublicApiController` + `APIItemController`).
5. **🟡 MÉDIO:** Limpar logs de debug e padronizar nomes de classes.

---

### Observação
O projeto evoluiu com as correções de crash, mas a camada de "Catálogo Público" parece ter sido deixada incompleta ou com referências a arquivos de uma versão anterior.
