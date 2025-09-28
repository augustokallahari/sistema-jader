<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
// Restrição para 'user' não é aplicada aqui, pois é a página permitida
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

// Processar cadastro de cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $nome_empresa = filter_input(INPUT_POST, 'nome_empresa', FILTER_SANITIZE_STRING);
    $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_STRING);
    $nome_responsavel = filter_input(INPUT_POST, 'nome_responsavel', FILTER_SANITIZE_STRING);
    $receita_mensal = filter_input(INPUT_POST, 'receita_mensal', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $producao_mensal = filter_input(INPUT_POST, 'producao_mensal', FILTER_SANITIZE_NUMBER_INT);
    $receita_producao = filter_input(INPUT_POST, 'receita_producao', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $oportunidades = filter_input(INPUT_POST, 'oportunidades', FILTER_SANITIZE_STRING);
    $produtos_concorrente = filter_input(INPUT_POST, 'produtos_concorrente', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $geolocalizacao = filter_input(INPUT_POST, 'geolocalizacao', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

    if ($nome_empresa && $cnpj && $nome_responsavel) {
        $stmt = $conn->prepare("INSERT INTO clientes (nome_empresa, cnpj, nome_responsavel, receita_mensal, producao_mensal, receita_producao, oportunidades, produtos_concorrente, endereco, geolocalizacao, telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdissssss", $nome_empresa, $cnpj, $nome_responsavel, $receita_mensal, $producao_mensal, $receita_producao, $oportunidades, $produtos_concorrente, $endereco, $geolocalizacao, $telefone);
        if ($stmt->execute()) {
            $mensagem = "Cliente cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar cliente.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios (Nome da Empresa, CNPJ, Nome do Responsável).";
    }
}

// Processar edição de cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome_empresa = filter_input(INPUT_POST, 'nome_empresa', FILTER_SANITIZE_STRING);
    $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_STRING);
    $nome_responsavel = filter_input(INPUT_POST, 'nome_responsavel', FILTER_SANITIZE_STRING);
    $receita_mensal = filter_input(INPUT_POST, 'receita_mensal', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $producao_mensal = filter_input(INPUT_POST, 'producao_mensal', FILTER_SANITIZE_NUMBER_INT);
    $receita_producao = filter_input(INPUT_POST, 'receita_producao', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $oportunidades = filter_input(INPUT_POST, 'oportunidades', FILTER_SANITIZE_STRING);
    $produtos_concorrente = filter_input(INPUT_POST, 'produtos_concorrente', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $geolocalizacao = filter_input(INPUT_POST, 'geolocalizacao', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

    if ($id && $nome_empresa && $cnpj && $nome_responsavel) {
        $stmt = $conn->prepare("UPDATE clientes SET nome_empresa = ?, cnpj = ?, nome_responsavel = ?, receita_mensal = ?, producao_mensal = ?, receita_producao = ?, oportunidades = ?, produtos_concorrente = ?, endereco = ?, geolocalizacao = ?, telefone = ? WHERE id = ?");
        $stmt->bind_param("sssdissssssi", $nome_empresa, $cnpj, $nome_responsavel, $receita_mensal, $producao_mensal, $receita_producao, $oportunidades, $produtos_concorrente, $endereco, $geolocalizacao, $telefone, $id);
        if ($stmt->execute()) {
            $mensagem = "Cliente atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar cliente.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha os campos obrigatórios.";
    }
}

// Processar exclusão de cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensagem = "Cliente excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir cliente.";
        }
        $stmt->close();
    }
}

// Consultar clientes
$query = "SELECT id, nome_empresa, cnpj, nome_responsavel, receita_mensal, producao_mensal, receita_producao, oportunidades, produtos_concorrente, endereco, geolocalizacao, telefone FROM clientes";
$result = $conn->query($query);

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/clientesvisual.php';
?>