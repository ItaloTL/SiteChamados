# Relatório de Erros Encontrados no Sistema

## 🔴 Erros Críticos

### 1. **index.php** - Falta session_start()
**Problema:** Arquivo usa `$_SESSION` mas não inicia sessão
**Solução:** Adicionar `session_start()` no início do arquivo, antes de qualquer uso de `$_SESSION`

### 2. **php/login.php** - Múltiplos erros
**Problema 1 (Linha 2-5):** Falta `session_start()` antes de usar sessões
**Problema 2 (Linha 7):** SQL Injection vulnerável
```php
$select = "SELECT * FROM usuario where email_usuario = '$email'";  // VULNERÁVEL
```
**Problema 3 (Linhas 13-14):** Acesso direto ao array sem verificar existência
```php
$email_banco = $resultado['email_usuario'];  // Pode causar erro se $resultado for null
$senha_banco = $resultado['senha_usuario'];
```
**Problema 4 (Linha 17):** Comparação de senha sem hash
```php
if ($email == $email_banco && $senha == $senha_banco){  // Senha em texto plano
```
**Problema 5 (Linha 19):** Nome de coluna incorreto
```php
$_SESSION['id_usuario'] = $resultado['id'];  // Deveria ser 'cd_usuario'
```
**Problema 6 (Linha 21):** URL incorreta no header
```php
header('location../index.php');  // Falta espaço e arquivo errado
```
**Problema 7 (Linha 23):** String JavaScript mal formatada
```php
echo "<script> alert('Usuário com a senha invalida!) history.back() </script>";  // Falta aspas e ;
```


## 📝 Erros Menores

### 7. **php/conexao.php** - Inconsistência de nome de banco
- Arquivo usa: `$database = "chamados"`
- README menciona: `db_sistema_chamado`

### 8. **db_sistema.sql** - Estrutura desatualizada
- SQL cria tabelas `novo_chamado` e `chamados`
- Código PHP espera tabela `chamado` (estrutura nova)

## 🛠️ Resumo de Correções Necessárias

1. ⚠️ Adicionar `session_start()` no início de index.php
2. ⚠️ Adicionar `session_start()` no início de login.php
3. ⚠️ Implementar prepared statements em login.php
4. ⚠️ Adicionar verificação de existência de resultados em login.php
5. ⚠️ Implementar verificação de hash de senha em login.php
6. ⚠️ Corrigir nome de coluna em login.php (usar 'cd_usuario' ou ajustar banco)
7. ⚠️ Corrigir URL de redirecionamento em login.php
8. ⚠️ Corrigir string JavaScript mal formatada em login.php
9. ⚠️ Padronizar nome do banco de dados (verificar se é intencional)

