 <?php
header('Content-Type: application/json; charset=utf-8');
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
$urgencia = isset($_POST['urgencia']) ? trim($_POST['urgencia']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

if (empty($tipo) || empty($urgencia) || empty($descricao) || strlen($descricao) < 10) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$usuarioId = 1; // ID fixo para simplificar

// Mapear valores de string para INT (conforme estrutura do banco)
$tipoMap = ['Problema Técnico' => 1, 'Dúvida' => 2, 'Solicitação' => 3];
$urgenciaMap = ['Baixa' => 1, 'Média' => 2, 'Alta' => 3, 'Urgente' => 4];

$tipoInt = $tipoMap[$tipo] ?? 1;
$urgenciaInt = $urgenciaMap[$urgencia] ?? 1;

$insert = "INSERT INTO novo_chamado (tp_chamado, tp_urgencia, ds_chamados, dt_chamado, fk_cd_usuario) 
           VALUES (?, ?, ?, CURDATE(), ?)";
$stmt = $conexao->prepare($insert);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro na preparação da query']);
    exit;
}

$stmt->bind_param("iisi", $tipoInt, $urgenciaInt, $descricao, $usuarioId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Chamado criado com sucesso!', 'id_chamado' => $conexao->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir: ' . $conexao->error]);
}

$stmt->close();
$conexao->close();
?>
 
