<?php
$email = $_POST['email'];
$senha = $_POST['senha'];

include 'conexao.php';

$select = "SELECT * FROM usuario where email_usuario = '$email'";

$query = $conexao->query($select);

$resultado = $query->fetch_assoc();

$email_banco = $resultado['email_usuario'];
$senha_banco = $resultado['senha_usuario'];


if ($email == $email_banco && $senha == $senha_banco){
    session_start();
    $_SESSION['id_usuario'] = $resultado['id_usuario'];
    $_SESSION['nm_usuario'] = $resultado ['nm_usuario'];
    header('location:../index.php');
}else{
    echo "<script> alert('Usuário com a senha invalida!'); history.back(); </script>";
}
?>
