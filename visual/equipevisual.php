<?php
// Receber variáveis do backend
$saudacao = isset($saudacao) ? $saudacao : "Olá";
$nome_usuario = isset($nome_usuario) ? $nome_usuario : "Usuário";
$mensagem = isset($mensagem) ? $mensagem : "";
$result_gerentes = isset($result_gerentes) ? $result_gerentes : null;
$result_vendedores = isset($result_vendedores) ? $result_vendedores : null;
$gerentes = isset($gerentes) ? $gerentes : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full - Equipe</title>
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
            margin-bottom: 40px;
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

        /* Estilo do botão de cadastro */
        .add-btn {
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            margin-right: 10px;
        }

        .add-btn:hover {
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

        .modal-content input, .modal-content textarea, .modal-content select {
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
        <h2>Gerenciamento de Equipe</h2>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Seção de Gerentes -->
        <h3>Gerentes</h3>
        <button class="add-btn" onclick="abrirModalCadastrarGerente()">Cadastrar Novo Gerente</button>

        <?php if ($result_gerentes): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Foco</th>
                        <th>Dados Reunião</th>
                        <th>Observação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_gerentes->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($row['foco']); ?></td>
                            <td><?php echo htmlspecialchars($row['dados_reuniao']); ?></td>
                            <td><?php echo htmlspecialchars($row['observacao']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="abrirModalEditarGerente(<?php echo htmlspecialchars(json_encode($row)); ?>)">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="excluir_gerente">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este gerente?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum gerente encontrado.</p>
        <?php endif; ?>

        <!-- Seção de Vendedores -->
        <h3>Vendedores</h3>
        <button class="add-btn" onclick="abrirModalCadastrarVendedor()">Cadastrar Novo Vendedor</button>

        <?php if ($result_vendedores): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Foco</th>
                        <th>Gerente Responsável</th>
                        <th>Observação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_vendedores->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($row['foco']); ?></td>
                            <td><?php echo htmlspecialchars($row['gerente_nome'] ?: 'Não atribuído'); ?></td>
                            <td><?php echo htmlspecialchars($row['observacao']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="abrirModalEditarVendedor(<?php echo htmlspecialchars(json_encode($row)); ?>)">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="excluir_vendedor">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum vendedor encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para cadastrar gerente -->
    <div id="modalCadastrarGerente" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalCadastrarGerente()">&times;</span>
            <h3>Cadastrar Novo Gerente</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_gerente">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="telefone" placeholder="Telefone" required>
                <input type="text" name="foco" placeholder="Foco">
                <textarea name="dados_reuniao" placeholder="Dados Reunião"></textarea>
                <textarea name="observacao" placeholder="Observação"></textarea>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar gerente -->
    <div id="modalEditarGerente" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditarGerente()">&times;</span>
            <h3>Editar Gerente</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_gerente">
                <input type="hidden" name="id" id="edit_gerente_id">
                <input type="text" name="nome" id="edit_gerente_nome" placeholder="Nome" required>
                <input type="text" name="telefone" id="edit_gerente_telefone" placeholder="Telefone" required>
                <input type="text" name="foco" id="edit_gerente_foco" placeholder="Foco">
                <textarea name="dados_reuniao" id="edit_gerente_dados_reuniao" placeholder="Dados Reunião"></textarea>
                <textarea name="observacao" id="edit_gerente_observacao" placeholder="Observação"></textarea>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <!-- Modal para cadastrar vendedor -->
    <div id="modalCadastrarVendedor" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalCadastrarVendedor()">&times;</span>
            <h3>Cadastrar Novo Vendedor</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_vendedor">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="telefone" placeholder="Telefone" required>
                <input type="text" name="foco" placeholder="Foco">
                <select name="gerente_id" required>
                    <option value="">Selecione um Gerente</option>
                    <?php while ($gerente = $gerentes->fetch_assoc()): ?>
                        <option value="<?php echo $gerente['id']; ?>"><?php echo htmlspecialchars($gerente['nome']); ?></option>
                    <?php endwhile; ?>
                </select>
                <textarea name="observacao" placeholder="Observação"></textarea>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar vendedor -->
    <div id="modalEditarVendedor" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditarVendedor()">&times;</span>
            <h3>Editar Vendedor</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_vendedor">
                <input type="hidden" name="id" id="edit_vendedor_id">
                <input type="text" name="nome" id="edit_vendedor_nome" placeholder="Nome" required>
                <input type="text" name="telefone" id="edit_vendedor_telefone" placeholder="Telefone" required>
                <input type="text" name="foco" id="edit_vendedor_foco" placeholder="Foco">
                <select name="gerente_id" id="edit_vendedor_gerente_id" required>
                    <option value="">Selecione um Gerente</option>
                    <?php while ($gerente = $gerentes->fetch_assoc()): ?>
                        <option value="<?php echo $gerente['id']; ?>"><?php echo htmlspecialchars($gerente['nome']); ?></option>
                    <?php endwhile; ?>
                </select>
                <textarea name="observacao" id="edit_vendedor_observacao" placeholder="Observação"></textarea>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModalCadastrarGerente() {
            document.getElementById('modalCadastrarGerente').style.display = 'flex';
        }

        function fecharModalCadastrarGerente() {
            document.getElementById('modalCadastrarGerente').style.display = 'none';
        }

        function abrirModalEditarGerente(gerente) {
            document.getElementById('edit_gerente_id').value = gerente.id;
            document.getElementById('edit_gerente_nome').value = gerente.nome;
            document.getElementById('edit_gerente_telefone').value = gerente.telefone;
            document.getElementById('edit_gerente_foco').value = gerente.foco;
            document.getElementById('edit_gerente_dados_reuniao').value = gerente.dados_reuniao;
            document.getElementById('edit_gerente_observacao').value = gerente.observacao;
            document.getElementById('modalEditarGerente').style.display = 'flex';
        }

        function fecharModalEditarGerente() {
            document.getElementById('modalEditarGerente').style.display = 'none';
        }

        function abrirModalCadastrarVendedor() {
            document.getElementById('modalCadastrarVendedor').style.display = 'flex';
        }

        function fecharModalCadastrarVendedor() {
            document.getElementById('modalCadastrarVendedor').style.display = 'none';
        }

        function abrirModalEditarVendedor(vendedor) {
            document.getElementById('edit_vendedor_id').value = vendedor.id;
            document.getElementById('edit_vendedor_nome').value = vendedor.nome;
            document.getElementById('edit_vendedor_telefone').value = vendedor.telefone;
            document.getElementById('edit_vendedor_foco').value = vendedor.foco;
            document.getElementById('edit_vendedor_gerente_id').value = vendedor.gerente_id;
            document.getElementById('edit_vendedor_observacao').value = vendedor.observacao;
            document.getElementById('modalEditarVendedor').style.display = 'flex';
        }

        function fecharModalEditarVendedor() {
            document.getElementById('modalEditarVendedor').style.display = 'none';
        }

        // Fechar os modais ao clicar fora deles
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCadastrarGerente')) {
                fecharModalCadastrarGerente();
            }
            if (event.target == document.getElementById('modalEditarGerente')) {
                fecharModalEditarGerente();
            }
            if (event.target == document.getElementById('modalCadastrarVendedor')) {
                fecharModalCadastrarVendedor();
            }
            if (event.target == document.getElementById('modalEditarVendedor')) {
                fecharModalEditarVendedor();
            }
        }
    </script>
</body>
</html>