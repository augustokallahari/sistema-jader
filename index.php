<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
// Restrição para 'user'
if ($_SESSION['permissao'] == 'user' && !in_array(basename($_SERVER['PHP_SELF']), ['clientes.php', 'login.php'])) {
    header('Location: clientes.php');
    exit;
}

// Definir o fuso horário para o Brasil
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

$nome_usuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário";

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/indexvisual.php';
?>