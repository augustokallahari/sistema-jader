<?php
// Receber variáveis do backend
$saudacao = isset($saudacao) ? $saudacao : "Olá";
$nome_usuario = isset($nome_usuario) ? $nome_usuario : "Usuário";
$mensagem = isset($mensagem) ? $mensagem : "";
$result = isset($result) ? $result : null;
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

        /* Estilo do formulário */
        .form-container {
            margin-bottom: 20px;
        }

        .form-container input {
            padding: 8px;
            margin: 5px 0;
            width: 200px;
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

        /* Estilo do modal */
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
        }

        .modal-content input {
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

        /* Estilo dos botões de ação */
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
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
        <h2>Lista de Produtos</h2>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Formulário para cadastrar produto -->
        <div class="form-container">
            <h3>Cadastrar Novo Produto</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar">
                <input type="text" name="nome" placeholder="Nome do Produto" required>
                <input type="text" name="codigo_produto" placeholder="Código do Produto" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        <!-- Tabela de produtos -->
        <?php if ($result): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Código do Produto</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['codigo_produto']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="abrirModalEditar(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nome']); ?>', '<?php echo htmlspecialchars($row['codigo_produto']); ?>')">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum produto encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para editar produto -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditar()">&times;</span>
            <h3>Editar Produto</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="nome" id="edit_nome" placeholder="Nome do Produto" required>
                <input type="text" name="codigo_produto" id="edit_codigo_produto" placeholder="Código do Produto" required>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModalEditar(id, nome, codigo_produto) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_codigo_produto').value = codigo_produto;
            document.getElementById('modalEditar').style.display = 'flex';
        }

        function fecharModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        // Fechar o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalEditar')) {
                fecharModalEditar();
            }
        }
    </script>
</body>
</html>