<?php
$email = $_POST['email'];
$senha = $_POST['senha'];

include 'conexao.php';

select = "SELECT * FROM usuario WHERE email_usuario = '$email'";

$query = $conexao-> query($select);0

$resultado = $query->fetch_assoc();
$email_banco = $resultado['email'];
$senha_banco = $resultado['senha'];
?>