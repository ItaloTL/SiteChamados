<?php
// Configurar cabeçalho para retornar JSON
header('Content-Type: application/json; charset=utf-8');

// Incluir o arquivo de conexão
include 'conexao.php';

// Verificar se existe sessão (opcional - pode funcionar sem login para testes)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar qual tabela existe no banco
$tabelaChamado = 'chamado';
$verificarTabela = "SHOW TABLES LIKE 'chamado'";
$resultTabela = $conexao->query($verificarTabela);

if (!$resultTabela || $resultTabela->num_rows == 0) {
    $tabelaChamado = 'novo_chamado';
}

$chamados = [];

if ($tabelaChamado === 'chamado') {
    // Estrutura nova: busca direta com strings
    
    $select = "SELECT c.id_chamado, c.tp_chamado, c.tp_urgencia, c.ds_chamado, c.st_chamado, 
                      c.dt_chamado, u.nm_usuario 
               FROM chamado c 
               JOIN usuario u ON c.fk_cd_usuario = u.cd_usuario 
               ORDER BY c.dt_chamado DESC";
    
    $resultado = $conexao->query($select);
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $chamados[] = [
                'id' => $row['id_chamado'],
                'tipo' => $row['tp_chamado'],
                'urgencia' => $row['tp_urgencia'],
                'descricao' => $row['ds_chamado'],
                'status' => $row['st_chamado'],
                'data' => $row['dt_chamado'],
                'usuario' => $row['nm_usuario']
            ];
        }
    }
} else {
    // Estrutura antiga: converter INTs para strings
    $tipoMap = [
        1 => 'Problema Técnico',
        2 => 'Dúvida',
        3 => 'Solicitação'
    ];
    $urgenciaMap = [
        1 => 'Baixa',
        2 => 'Média',
        3 => 'Alta',
        4 => 'Urgente'
    ];
    
    $select = "SELECT nc.id_chamado, nc.tp_chamado, nc.tp_urgencia, nc.ds_chamados, 
                      nc.dt_chamado, u.nm_usuario, c.st_chamados
               FROM novo_chamado nc
               JOIN usuario u ON nc.fk_cd_usuario = u.cd_usuario
               LEFT JOIN chamados c ON c.fk_id_chamados = nc.id_chamado
               ORDER BY nc.dt_chamado DESC";
    
    $resultado = $conexao->query($select);
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $chamados[] = [
                'id' => $row['id_chamado'],
                'tipo' => isset($tipoMap[$row['tp_chamado']]) ? $tipoMap[$row['tp_chamado']] : 'Desconhecido',
                'urgencia' => isset($urgenciaMap[$row['tp_urgencia']]) ? $urgenciaMap[$row['tp_urgencia']] : 'Desconhecida',
                'descricao' => $row['ds_chamados'],
                'status' => $row['st_chamados'] ? $row['st_chamados'] : 'Aberto',
                'data' => $row['dt_chamado'],
                'usuario' => $row['nm_usuario']
            ];
        }
    }
}

// Retornar JSON
echo json_encode(['success' => true, 'chamados' => $chamados]);

$conexao->close();
?>

