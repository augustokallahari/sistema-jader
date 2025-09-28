<?php
// Receber variáveis do backend
$saudacao = isset($saudacao) ? $saudacao : "Olá";
$nome_usuario = isset($nome_usuario) ? $nome_usuario : "Usuário";
$mensagem = isset($mensagem) ? $mensagem : "";
$result_pedidos = isset($result_pedidos) ? $result_pedidos : null;
$itens_pedidos = isset($itens_pedidos) ? $itens_pedidos : [];
$clientes = isset($clientes) ? $clientes : null;
$produtos = isset($produtos) ? $produtos : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full - Pedidos</title>
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
            justify-content: space-between;
            align-items: center;
        }

        .user-box {
            display: flex;
            align-items: center;
            background-color: #444;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .user-box span {
            margin-right: 10px;
        }

        .logout-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        /* Estilo do conteúdo principal */
        .content {
            margin-left: 200px;
            margin-top: 60px;
            padding: 20px;
            width: 100%;
        }

        /* Estilo da tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Estilo do formulário e modal */
        .form-container {
            margin-bottom: 20px;
        }

        .form-container button {
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #555;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-content select, .modal-content input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }

        .modal-content button {
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #555;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }

        .produto-linha {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .produto-linha button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }

        .produto-linha button:hover {
            background-color: #d32f2f;
        }

        /* Estilo da mensagem */
        .mensagem {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .mensagem.sucesso {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .mensagem.erro {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <!-- Menu lateral -->
    <div class="sidebar">
        <ul>
            <li><a href="equipe.php">Equipe</a></li>
            <li><a href="pedidos.php">Pedidos</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="relatorios.php">Relatórios</a></li>
            <li><a href="configuracoes.php">Configurações</a></li>
        </ul>
    </div>

    <!-- Cabeçalho -->
    <div class="header">
        <div class="user-box">
            <span><?php echo "$saudacao, $nome_usuario"; ?></span>
            <a href="?logout=1" class="logout-btn">Sair</a>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="content">
        <h2>Gerenciamento de Pedidos</h2>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Botão para abrir o modal de criar pedido -->
        <div class="form-container">
            <button onclick="abrirModalCriarPedido()">Criar Pedido</button>
        </div>

        <!-- Modal para criar pedido -->
        <div id="modalCriarPedido" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModalCriarPedido()">&times;</span>
                <h3>Criar Novo Pedido</h3>
                <form method="POST" action="">
                    <input type="hidden" name="acao" value="criar_pedido">
                    <select name="cliente_id" required>
                        <option value="">Selecione um Cliente</option>
                        <?php while ($cliente = $clientes->fetch_assoc()): ?>
                            <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nome_empresa']); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div id="produtos-container">
                        <div class="produto-linha">
                            <select name="produtos[]" required>
                                <option value="">Selecione um Produto</option>
                                <?php while ($produto = $produtos->fetch_assoc()): ?>
                                    <option value="<?php echo $produto['id']; ?>"><?php echo htmlspecialchars($produto['nome']) . ' (' . htmlspecialchars($produto['codigo_produto']) . ')'; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <input type="number" name="quantidades[]" placeholder="Quantidade" min="1" value="1" required>
                            <button type="button" onclick="this.parentElement.remove()">Remover</button>
                        </div>
                    </div>
                    <button type="button" onclick="adicionarProduto()">Adicionar Produto</button>
                    <button type="submit">Salvar Pedido</button>
                </form>
            </div>
        </div>

        <!-- Tabela de pedidos -->
        <?php if ($result_pedidos): ?>
            <h3>Lista de Pedidos</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Itens</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = $result_pedidos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['vendedor']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                            <td>
                                <ul>
                                    <?php foreach ($itens_pedidos[$pedido['id']] ?? [] as $item): ?>
                                        <li><?php echo htmlspecialchars($item['produto_nome']) . " (Qtd: " . htmlspecialchars($item['quantidade']) . ")"; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum pedido encontrado.</p>
        <?php endif; ?>
    </div>

    <script>
        function abrirModalCriarPedido() {
            document.getElementById('modalCriarPedido').style.display = 'flex';
        }

        function fecharModalCriarPedido() {
            document.getElementById('modalCriarPedido').style.display = 'none';
        }

        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const linha = document.querySelector('.produto-linha').cloneNode(true);
            linha.querySelector('select').value = '';
            linha.querySelector('input').value = '1';
            container.appendChild(linha);
        }

        // Inicializar com pelo menos uma linha de produto
        window.onload = function() {
            adicionarProduto();
        };

        // Fechar o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCriarPedido')) {
                fecharModalCriarPedido();
            }
        }
    </script>
</body>
</html>