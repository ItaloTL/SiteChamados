<?php
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confsenha = $_POST['confSenha'];


//incluir o arquivo conexao
    include 'conexao.php';

//instrução sqç para inserir os dados
$insert = "INSERT INTO tb_usuario(null, '$nome', 'senha', "


?>