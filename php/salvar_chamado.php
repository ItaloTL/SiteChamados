<?php
// Configurar cabeçalho para retornar JSON
header('Content-Type: application/json; charset=utf-8');

// Incluir o arquivo de conexão
include 'conexao.php';

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Receber os dados do formulário
$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
$urgencia = isset($_POST['urgencia']) ? trim($_POST['urgencia']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

// Validar campos obrigatórios
if (empty($tipo) || empty($urgencia) || empty($descricao)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos']);
    exit;
}

// Validar tamanho mínimo da descrição
if (strlen($descricao) < 10) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'A descrição deve ter pelo menos 10 caracteres']);
    exit;
}

// Validar tipo de chamado
$tiposValidos = ['Problema Técnico', 'Dúvida', 'Solicitação'];
if (!in_array($tipo, $tiposValidos)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tipo de chamado inválido']);
    exit;
}

// Validar urgência
$urgenciasValidas = ['Baixa', 'Média', 'Alta', 'Urgente'];
if (!in_array($urgencia, $urgenciasValidas)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nível de urgência inválido']);
    exit;
}

// Verificar se existe sessão (usuário logado)
// Se não houver sistema de sessão, usar um ID fixo ou permitir sem usuário
$usuarioId = null;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario'])) {
    $usuarioId = $_SESSION['id_usuario'];
} else {
    // Se não houver usuário logado, buscar o primeiro usuário ou usar NULL
    // Isso permite testar o sistema sem login
    $queryUsuario = "SELECT id_usuario FROM usuario LIMIT 1";
    $resultUsuario = $conexao->query($queryUsuario);
    if ($resultUsuario && $resultUsuario->num_rows > 0) {
        $rowUsuario = $resultUsuario->fetch_assoc();
        $usuarioId = $rowUsuario['id _usuario'];
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Nenhum usuário encontrado no sistema']);
        exit;
    }
}

// Verificar se a tabela 'chamado' existe (estrutura nova) ou 'novo_chamado' (estrutura antiga)
$tabelaChamado = 'chamado';
$verificarTabela = "SHOW TABLES LIKE 'chamado'";
$resultTabela = $conexao->query($verificarTabela);

if (!$resultTabela || $resultTabela->num_rows == 0) {
    // Tentar com a tabela antiga
    $tabelaChamado = 'novo_chamado';
    $verificarTabelaAntiga = "SHOW TABLES LIKE 'novo_chamado'";
    $resultTabelaAntiga = $conexao->query($verificarTabelaAntiga);
    
    if (!$resultTabelaAntiga || $resultTabelaAntiga->num_rows == 0) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Tabela de chamados não encontrada no banco de dados']);
        exit;
    }
}

// Preparar dados para inserção
if ($tabelaChamado === 'chamado') {
    // Estrutura nova: campos como VARCHAR (strings)
    $insert = "INSERT INTO chamado (tp_chamado, tp_urgencia, ds_chamado, st_chamado, fk_cd_usuario) VALUES (?, ?, ?, 'Aberto', ?)";
    $stmt = $conexao->prepare($insert);
    $stmt->bind_param("sssi", $tipo, $urgencia, $descricao, $usuarioId);
} else {
    // Estrutura antiga: converter strings para INT
    $tipoMap = [
        'Problema Técnico' => 1,
        'Dúvida' => 2,
        'Solicitação' => 3
    ];
    $urgenciaMap = [
        'Baixa' => 1,
        'Média' => 2,
        'Alta' => 3,
        'Urgente' => 4
    ];
    
    $tipoInt = isset($tipoMap[$tipo]) ? $tipoMap[$tipo] : 1;
    $urgenciaInt = isset($urgenciaMap[$urgencia]) ? $urgenciaMap[$urgencia] : 1;
    
    $insert = "INSERT INTO novo_chamado (tp_chamado, tp_urgencia, ds_chamados, dt_chamado, fk_cd_usuario) VALUES (?, ?, ?, CURDATE(), ?)";
    $stmt = $conexao->prepare($insert);
    $stmt->bind_param("iisi", $tipoInt, $urgenciaInt, $descricao, $usuarioId);
}

// Executar a inserção
if ($stmt->execute()) {
    $idChamado = $conexao->insert_id;
    
    // Se for estrutura antiga, criar registro na tabela chamados
    if ($tabelaChamado === 'novo_chamado') {
        $insertStatus = "INSERT INTO chamados (st_chamados, qt_chamados, fk_id_chamados) VALUES ('Aberto', 1, ?)";
        $stmtStatus = $conexao->prepare($insertStatus);
        $stmtStatus->bind_param("i", $idChamado);
        $stmtStatus->execute();
        $stmtStatus->close();
    }
    
    echo json_encode([
        'success' => true, 
        'message' => 'Chamado criado com sucesso!',
        'id_chamado' => $idChamado
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao criar chamado: ' . $conexao->error]);
}

$stmt->close();
$conexao->close();
?>

