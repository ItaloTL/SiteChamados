# Relatório de Erros Encontrados no Sistema


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
$_SESSION['id_usuario'] = $resultado['id_usuario'];  // Banco tem 'cd_usuario', não 'id_usuario'
```

## 📝 Erros Menores

### 7. **php/conexao.php** - Inconsistência de nome de banco
- Arquivo usa: `$database = "chamados"`
- README menciona: `db_sistema_chamado`

### 8. **db_sistema.sql** - Estrutura desatualizada
- SQL cria tabelas `novo_chamado` e `chamados`
- Código PHP espera tabela `chamado` (estrutura nova)

## 🛠️ Resumo de Correções Necessárias

3. ⚠️ Implementar prepared statements em login.php (corrigir SQL Injection)
4. ⚠️ Adicionar verificação de existência de resultados em login.php (verificar se $resultado não é null)
5. ⚠️ Implementar verificação de hash de senha em login.php (usar password_verify)

7. ⚠️ Padronizar nome do banco de dados (verificar se é intencional)

