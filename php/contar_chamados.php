<?php
// Configurar cabeçalho para retornar JSON
header('Content-Type: application/json; charset=utf-8');

// Incluir o arquivo de conexão
include 'conexao.php';

// Verificar qual tabela existe no banco
$tabelaChamado = 'chamado';
$verificarTabela = "SHOW TABLES LIKE 'chamado'";
$resultTabela = $conexao->query($verificarTabela);

if (!$resultTabela || $resultTabela->num_rows == 0) {
    $tabelaChamado = 'novo_chamado';
}

if ($tabelaChamado === 'chamado') {
    // Estrutura nova: contar diretamente
    $select = "SELECT 
        COUNT(CASE WHEN st_chamado = 'Aberto' THEN 1 END) AS abertos,
        COUNT(CASE WHEN st_chamado = 'Pendente' OR st_chamado = 'Em andamento' THEN 1 END) AS pendentes,
        COUNT(*) AS total
    FROM chamado";
} else {
    // Estrutura antiga: contar da tabela chamados
    $select = "SELECT 
        COUNT(CASE WHEN st_chamados = 'Aberto' THEN 1 END) AS abertos,
        COUNT(CASE WHEN st_chamados = 'Pendente' OR st_chamados = 'Em andamento' THEN 1 END) AS pendentes,
        COUNT(*) AS total
    FROM chamados";
}

$resultado = $conexao->query($select);

if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    echo json_encode([
        'success' => true,
        'abertos' => (int)$row['abertos'],
        'pendentes' => (int)$row['pendentes'],
        'total' => (int)$row['total']
    ]);
} else {
    echo json_encode([
        'success' => true,
        'abertos' => 0,
        'pendentes' => 0,
        'total' => 0
    ]);
}

$conexao->close();
?>

