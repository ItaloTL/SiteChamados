<?php
    $server = "localhost";
    $user = "root";
    $password = "admin";
    $database = "db_sistema";


    $conexao = new mysqli($server, $user, $password, $database);

    if ($conexao == true) {
        echo "conectado com sucesso!";
    }
    

?> 