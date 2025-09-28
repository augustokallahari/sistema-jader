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

require_once 'conexao.php';

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

// Processar cadastro de produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $codigo_produto = filter_input(INPUT_POST, 'codigo_produto', FILTER_SANITIZE_STRING);
    
    if ($nome && $codigo_produto) {
        $stmt = $conn->prepare("INSERT INTO produtos (nome, codigo_produto) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $codigo_produto);
        if ($stmt->execute()) {
            $mensagem = "Produto cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar produto.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

// Processar edição de produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $codigo_produto = filter_input(INPUT_POST, 'codigo_produto', FILTER_SANITIZE_STRING);
    
    if ($id && $nome && $codigo_produto) {
        $stmt = $conn->prepare("UPDATE produtos SET nome = ?, codigo_produto = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $codigo_produto, $id);
        if ($stmt->execute()) {
            $mensagem = "Produto atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar produto.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

// Processar exclusão de produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensagem = "Produto excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir produto.";
        }
        $stmt->close();
    }
}

// Consultar produtos
$query = "SELECT id, nome, codigo_produto FROM produtos";
$result = $conn->query($query);

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/produtosvisual.php';
?>