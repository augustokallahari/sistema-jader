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

// Processar cadastro de gerente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar_gerente') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $foco = filter_input(INPUT_POST, 'foco', FILTER_SANITIZE_STRING);
    $dados_reuniao = filter_input(INPUT_POST, 'dados_reuniao', FILTER_SANITIZE_STRING);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);

    if ($nome && $telefone) {
        $stmt = $conn->prepare("INSERT INTO gerentes (nome, telefone, foco, dados_reuniao, observacao) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $telefone, $foco, $dados_reuniao, $observacao);
        if ($stmt->execute()) {
            $mensagem = "Gerente cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar gerente.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios (Nome, Telefone).";
    }
}

// Processar edição de gerente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar_gerente') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $foco = filter_input(INPUT_POST, 'foco', FILTER_SANITIZE_STRING);
    $dados_reuniao = filter_input(INPUT_POST, 'dados_reuniao', FILTER_SANITIZE_STRING);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);

    if ($id && $nome && $telefone) {
        $stmt = $conn->prepare("UPDATE gerentes SET nome = ?, telefone = ?, foco = ?, dados_reuniao = ?, observacao = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nome, $telefone, $foco, $dados_reuniao, $observacao, $id);
        if ($stmt->execute()) {
            $mensagem = "Gerente atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar gerente.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios.";
    }
}

// Processar exclusão de gerente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir_gerente') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM gerentes WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensagem = "Gerente excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir gerente.";
        }
        $stmt->close();
    }
}

// Processar cadastro de vendedor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar_vendedor') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $foco = filter_input(INPUT_POST, 'foco', FILTER_SANITIZE_STRING);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
    $gerente_id = filter_input(INPUT_POST, 'gerente_id', FILTER_SANITIZE_NUMBER_INT);

    if ($nome && $telefone && $gerente_id) {
        $stmt = $conn->prepare("INSERT INTO vendedores (nome, telefone, foco, observacao, gerente_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $nome, $telefone, $foco, $observacao, $gerente_id);
        if ($stmt->execute()) {
            $mensagem = "Vendedor cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar vendedor.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios (Nome, Telefone, Gerente).";
    }
}

// Processar edição de vendedor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar_vendedor') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $foco = filter_input(INPUT_POST, 'foco', FILTER_SANITIZE_STRING);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
    $gerente_id = filter_input(INPUT_POST, 'gerente_id', FILTER_SANITIZE_NUMBER_INT);

    if ($id && $nome && $telefone && $gerente_id) {
        $stmt = $conn->prepare("UPDATE vendedores SET nome = ?, telefone = ?, foco = ?, observacao = ?, gerente_id = ? WHERE id = ?");
        $stmt->bind_param("sssiii", $nome, $telefone, $foco, $observacao, $gerente_id, $id);
        if ($stmt->execute()) {
            $mensagem = "Vendedor atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar vendedor.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios.";
    }
}

// Processar exclusão de vendedor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir_vendedor') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM vendedores WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensagem = "Vendedor excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir vendedor.";
        }
        $stmt->close();
    }
}

// Consultar gerentes
$query_gerentes = "SELECT id, nome, telefone, foco, dados_reuniao, observacao FROM gerentes";
$result_gerentes = $conn->query($query_gerentes);

// Consultar vendedores
$query_vendedores = "SELECT v.id, v.nome, v.telefone, v.foco, v.observacao, v.gerente_id, g.nome AS gerente_nome FROM vendedores v LEFT JOIN gerentes g ON v.gerente_id = g.id";
$result_vendedores = $conn->query($query_vendedores);

// Obter lista de gerentes para o select
$gerentes = $conn->query("SELECT id, nome FROM gerentes");

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/equipevisual.php';
?>