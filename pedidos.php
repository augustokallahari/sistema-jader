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
$vendedor_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Consultar clientes e produtos para os selects
$clientes = $conn->query("SELECT id, nome_empresa FROM clientes");
$produtos = $conn->query("SELECT id, nome, codigo_produto FROM produtos");

// Processar criação de pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'criar_pedido') {
    $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_NUMBER_INT);
    $produtos_selecionados = isset($_POST['produtos']) ? $_POST['produtos'] : [];
    $quantidades = isset($_POST['quantidades']) ? $_POST['quantidades'] : [];

    if ($cliente_id && $vendedor_id && !empty($produtos_selecionados)) {
        $conn->begin_transaction();
        try {
            // Inserir pedido
            $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, vendedor_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $cliente_id, $vendedor_id);
            $stmt->execute();
            $pedido_id = $conn->insert_id;
            $stmt->close();

            // Inserir itens do pedido
            $stmt = $conn->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)");
            for ($i = 0; $i < count($produtos_selecionados); $i++) {
                $produto_id = $produtos_selecionados[$i];
                $quantidade = $quantidades[$i] ?? 1;
                $stmt->bind_param("iii", $pedido_id, $produto_id, $quantidade);
                $stmt->execute();
            }
            $stmt->close();

            $conn->commit();
            $mensagem = "Pedido criado com sucesso!";
        } catch (Exception $e) {
            $conn->rollback();
            $mensagem = "Erro ao criar pedido: " . $e->getMessage();
        }
    } else {
        $mensagem = "Selecione um cliente e pelo menos um produto.";
    }
}

// Consultar pedidos
$query_pedidos = "SELECT p.id, c.nome_empresa AS cliente, u.nome AS vendedor, p.data_pedido, p.status 
                  FROM pedidos p 
                  JOIN clientes c ON p.cliente_id = c.id 
                  JOIN usuarios u ON p.vendedor_id = u.id";
$result_pedidos = $conn->query($query_pedidos);

// Consultar itens dos pedidos para exibição
$itens_pedidos = [];
if ($result_pedidos) {
    while ($pedido = $result_pedidos->fetch_assoc()) {
        $pedido_id = $pedido['id'];
        $query_itens = "SELECT ip.quantidade, pr.nome AS produto_nome 
                        FROM itens_pedido ip 
                        JOIN produtos pr ON ip.produto_id = pr.id 
                        WHERE ip.pedido_id = ?";
        $stmt = $conn->prepare($query_itens);
        $stmt->bind_param("i", $pedido_id);
        $stmt->execute();
        $result_itens = $stmt->get_result();
        $itens = $result_itens->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $itens_pedidos[$pedido_id] = $itens;
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Incluir o visual
include 'visual/pedidosvisual.php';
?>