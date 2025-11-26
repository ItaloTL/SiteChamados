<?php
// Informações para conectar no SGBD
$server = "localhost";
$user = "root";
$password = "admin";
$database = "chamados";

// Criar conexão
$conexao = new mysqli($server, $user, $password, $database);

// Verificar conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Definir charset para UTF-8
$conexao->set_charset("utf8");
?>