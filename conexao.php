<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'banco-jader-sistema';

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>