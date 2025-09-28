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

// Consultar equipe para o select de referência
$equipe = $conn->query("SELECT id, nome, 'equipe' as tipo FROM gerentes UNION SELECT id, nome, 'equipe' as tipo FROM vendedores");

// Processar cadastro de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar_usuario') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $permissao = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_STRING);
    $referencia_id = filter_input(INPUT_POST, 'referencia_id', FILTER_SANITIZE_NUMBER_INT) ?: null;

    if ($nome && $email && $senha && $permissao) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, permissao, referencia_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nome, $email, $senha, $permissao, $referencia_id);
        if ($stmt->execute()) {
            $mensagem = "Usuário cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar usuário: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}

// Processar edição de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar_usuario') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $permissao = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_STRING);
    $referencia_id = filter_input(INPUT_POST, 'referencia_id', FILTER_SANITIZE_NUMBER_INT) ?: null;

    if ($id && $nome && $email && $senha && $permissao) {
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, permissao = ?, referencia_id = ? WHERE id = ?");
        $stmt->bind_param("sssiii", $nome, $email, $senha, $permissao, $referencia_id, $id);
        if ($stmt->execute()) {
            $mensagem = "Usuário atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar usuário: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}

// Processar exclusão de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir_usuario') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensagem = "Usuário excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir usuário: " . $conn->error;
        }
        $stmt->close();
    }
}

// Consultar usuários
$query = "SELECT id, nome, email, senha, permissao, referencia_id FROM usuarios";
$result = $conn->query($query);

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/configuracoesvisual.php';
?>