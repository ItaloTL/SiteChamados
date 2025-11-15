# Sistema de Chamados - Integração com Banco de Dados

## Estrutura do Banco de Dados

### Tabelas Criadas

1. **usuario**
   - `cd_usuario` (INT, AUTO_INCREMENT, PRIMARY KEY)
   - `nm_usuario` (VARCHAR(100))
   - `senha_usuario` (VARCHAR(255)) - Senha criptografada com password_hash
   - `email_usuario` (VARCHAR(150), UNIQUE)
   - `dt_cadastro` (DATETIME) - Data de cadastro automática

2. **chamado**
   - `id_chamado` (INT, AUTO_INCREMENT, PRIMARY KEY)
   - `tp_chamado` (VARCHAR(50)) - Tipo: "Problema Técnico", "Dúvida", "Solicitação"
   - `tp_urgencia` (VARCHAR(20)) - Urgência: "Baixa", "Média", "Alta", "Urgente"
   - `ds_chamado` (TEXT) - Descrição do chamado
   - `st_chamado` (VARCHAR(20)) - Status: "Aberto", "Pendente", "Em andamento", "Concluído"
   - `dt_chamado` (DATETIME) - Data de criação automática
   - `fk_cd_usuario` (INT, FOREIGN KEY) - Referência ao usuário

## Arquivos PHP Criados

### 1. `php/conexao.php`
- Arquivo de conexão com o banco de dados
- Configurações: localhost, root, admin, db_sistema_chamado
- **IMPORTANTE**: Ajuste as credenciais conforme seu ambiente

### 2. `php/cad_usuario.php`
- Cadastro de novos usuários
- Validações: campos obrigatórios, email válido, senhas coincidem, senha mínima 6 caracteres
- Senha criptografada com `password_hash()`
- Verifica se email já existe

### 3. `php/login.php`
- Autenticação de usuários
- Verifica email e senha
- Cria sessão PHP com dados do usuário
- Redireciona para index.html após login

### 4. `php/salvar_chamado.php`
- Salva novos chamados no banco
- Requer usuário autenticado (sessão)
- Valida campos obrigatórios
- Retorna JSON com sucesso/erro

### 5. `php/buscar_chamados.php`
- Busca todos os chamados do banco
- Requer usuário autenticado
- Retorna JSON com lista de chamados
- Inclui informações do usuário que criou o chamado

### 6. `php/contar_chamados.php`
- Conta chamados por status
- Retorna contadores: abertos, pendentes, total
- Usado para atualizar cards na página inicial

### 7. `php/verificar_sessao.php`
- Verifica se usuário está autenticado
- Pode ser incluído em páginas protegidas

## Como Usar

### 1. Configurar Banco de Dados

```sql
-- Execute o arquivo db_sistema.sql no MySQL
mysql -u root -p < db_sistema.sql
```

Ou importe via phpMyAdmin/MySQL Workbench.

### 2. Configurar Conexão

Edite `php/conexao.php` com suas credenciais:
```php
$server = "localhost";
$user = "seu_usuario";
$password = "sua_senha";
$database = "db_sistema_chamado";
```

### 3. Testar o Sistema

1. Acesse `cadastro.html` e crie uma conta
2. Faça login em `login.html`
3. Crie chamados em `index.html`
4. Visualize chamados em `abertos.html`

## Correções Realizadas

1. ✅ Estrutura do banco reorganizada e corrigida
2. ✅ Nome do banco unificado: `db_sistema_chamado`
3. ✅ Campos de tipo e urgência alterados para VARCHAR (strings)
4. ✅ Descrição alterada para TEXT (suporta textos longos)
5. ✅ Data alterada para DATETIME (inclui hora)
6. ✅ Tabela `chamados` removida (estrutura confusa)
7. ✅ Status integrado na tabela `chamado`
8. ✅ Arquivo `cad_usuario.php` corrigido com validações
9. ✅ Sistema de login implementado
10. ✅ Integração completa entre frontend e backend

## Estrutura de Dados

### Chamado (JSON esperado pelo frontend)
```json
{
  "id": 1,
  "tipo": "Problema Técnico",
  "urgencia": "Alta",
  "descricao": "Descrição do problema...",
  "data": "2024-01-15 10:30:00",
  "status": "Aberto",
  "usuario": "Nome do Usuário"
}
```

## Segurança

- ✅ Senhas criptografadas com `password_hash()`
- ✅ Verificação de sessão em endpoints protegidos
- ✅ Validação de dados no backend
- ✅ Prepared statements para prevenir SQL Injection
- ✅ Validação de email e campos obrigatórios

## Próximos Passos (Opcional)

- Implementar logout
- Adicionar edição/exclusão de chamados
- Implementar filtros na página de abertos
- Adicionar paginação para muitos chamados
- Implementar sistema de notificações

