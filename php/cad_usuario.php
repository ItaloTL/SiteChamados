<?php
//Recebendo os dados do formulario
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';


//incluir o arquivo de conexão
include 'conexao.php';

// validar campos obrigatórios
// if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
//     echo "<script> alert('Por favor, preencha todos os campos.'); window.history.back(); </script>";
//     exit;
// }

// verificar se as senhas coincidem
// if ($senha !== $confirmarSenha) {
//     echo "<script> alert('As senhas não coincidem.'); window.history.back(); </script>";
//     exit;
// }

// hash da senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// preparar e executar a instrução SQL de forma segura
$stmt = $conexao->prepare("INSERT INTO usuario (nm_usuario, senha_usuario, email_usuario) VALUES (?, ?, ?)");
if ($stmt === false) {
    echo "<script> alert('Erro ao preparar consulta: " . $conexao->error . "'); window.history.back(); </script>";
    exit;
}
$stmt->bind_param("sss", $nome, $senhaHash, $email);

if ($stmt->execute()) {
    echo "<script> alert('Usuário cadastrado com sucesso!'); window.location.href = '../index.html'; </script>";
} else {
    echo "<script> alert('Erro ao cadastrar usuário: " . $stmt->error . "'); window.history.back(); </script>";
}

// $stmt->close();
// $conexao->close();

?>