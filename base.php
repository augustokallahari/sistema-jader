<?php
session_start();

// Definir o fuso horário para o Brasil (ajuste conforme necessário)
date_default_timezone_set('America/Sao_Paulo');

// Lógica para determinar a saudação com base no horário
$hora = date('H');
if ($hora >= 5 && $hora < 12) {
    $saudacao = "Bom dia";
} elseif ($hora >= 12 && $hora < 18) {
    $saudacao = "Boa tarde";
} else {
    $saudacao = "Boa noite";
}

// Nome do usuário (substitua pela lógica real de autenticação)
$nome_usuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }

        /* Estilo do menu lateral */
        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
        }

        .sidebar ul li a:hover {
            background-color: #ddd;
        }

        /* Estilo do cabeçalho */
        .header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 200px;
            height: 60px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Estilo do conteúdo principal */
        .content {
            margin-left: 200px;
            margin-top: 60px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Menu lateral -->
    <div class="sidebar">
        <ul>
            <li><a href="equipe.php">Equipe</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="relatorios.php">Relatórios</a></li>
            <li><a href="configuracoes.php">Configurações</a></li>
        </ul>
    </div>

    <!-- Cabeçalho -->
    <div class="header">
        <span><?php echo "$saudacao, $nome_usuario"; ?></span>
    </div>

    <!-- Conteúdo principal (em branco) -->
    <div class="content">
        <!-- Conteúdo será adicionado aqui -->
    </div>
</body>
</html>