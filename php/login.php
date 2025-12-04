<?php
$email = $_POST['email'];
$senha = $_POST['senha'];

include 'conexao.php';

$select = "SELECT * FROM usuario WHERE email_usuario = ?";

$stmt = $conexao->prepare($select);
$stmt->bind_param("s", $email);
$stmt->execute();
$query = $stmt->get_result();

$resultado = $query->fetch_assoc();

if ($resultado && password_verify($senha, $resultado['senha_usuario'])){
    
    session_start();
    $_SESSION['cd_usuario'] = $resultado['cd_usuario'];
    $_SESSION['nm_usuario'] = $resultado['nm_usuario'];
    header('location:../index.html');
}else{
    echo "<script> alert('Usuário com a senha invalida!'); history.back(); </script>";
}
?>
