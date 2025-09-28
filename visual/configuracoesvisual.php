<?php
// Receber variáveis do backend
$saudacao = isset($saudacao) ? $saudacao : "Olá";
$nome_usuario = isset($nome_usuario) ? $nome_usuario : "Usuário";
$mensagem = isset($mensagem) ? $mensagem : "";
$result = isset($result) ? $result : null;
$equipe = isset($equipe) ? $equipe : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full - Configurações</title>
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

        /* Estilo do botão de cadastro */
        .add-btn {
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
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

        .modal-content input, .modal-content select {
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
        <h2>Configurações - Usuários</h2>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Botão para abrir o modal de cadastro -->
        <button class="add-btn" onclick="abrirModalCadastrarUsuario()">Cadastrar Novo Usuário</button>

        <!-- Tabela de usuários -->
        <?php if ($result): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Permissão</th>
                        <th>Referência</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo str_repeat('*', strlen($row['senha'])); ?></td>
                            <td><?php echo htmlspecialchars($row['permissao']); ?></td>
                            <td><?php echo $row['referencia_id'] ? "Equipe ID: " . htmlspecialchars($row['referencia_id']) : 'Nenhum'; ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="abrirModalEditarUsuario(<?php echo htmlspecialchars(json_encode($row)); ?>)">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="excluir_usuario">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum usuário encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para cadastrar usuário -->
    <div id="modalCadastrarUsuario" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalCadastrarUsuario()">&times;</span>
            <h3>Cadastrar Novo Usuário</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_usuario">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <select name="permissao" required>
                    <option value="">Selecione a Permissão</option>
                    <option value="adm">Adm (Controle Total)</option>
                    <option value="user">User (Apenas Clientes)</option>
                </select>
                <select name="referencia_id">
                    <option value="0">Sem Referência</option>
                    <?php while ($membro = $equipe->fetch_assoc()): ?>
                        <option value="<?php echo $membro['id']; ?>"><?php echo htmlspecialchars($membro['nome']); ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar usuário -->
    <div id="modalEditarUsuario" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditarUsuario()">&times;</span>
            <h3>Editar Usuário</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_usuario">
                <input type="hidden" name="id" id="edit_usuario_id">
                <input type="text" name="nome" id="edit_usuario_nome" placeholder="Nome" required>
                <input type="email" name="email" id="edit_usuario_email" placeholder="Email" required>
                <input type="password" name="senha" id="edit_usuario_senha" placeholder="Senha" required>
                <select name="permissao" id="edit_usuario_permissao" required>
                    <option value="">Selecione a Permissão</option>
                    <option value="adm">Adm (Controle Total)</option>
                    <option value="user">User (Apenas Clientes)</option>
                </select>
                <select name="referencia_id" id="edit_usuario_referencia_id">
                    <option value="0">Sem Referência</option>
                    <?php $equipe->data_seek(0); while ($membro = $equipe->fetch_assoc()): ?>
                        <option value="<?php echo $membro['id']; ?>"><?php echo htmlspecialchars($membro['nome']); ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModalCadastrarUsuario() {
            document.getElementById('modalCadastrarUsuario').style.display = 'flex';
        }

        function fecharModalCadastrarUsuario() {
            document.getElementById('modalCadastrarUsuario').style.display = 'none';
        }

        function abrirModalEditarUsuario(usuario) {
            document.getElementById('edit_usuario_id').value = usuario.id;
            document.getElementById('edit_usuario_nome').value = usuario.nome;
            document.getElementById('edit_usuario_email').value = usuario.email;
            document.getElementById('edit_usuario_senha').value = usuario.senha;
            document.getElementById('edit_usuario_permissao').value = usuario.permissao;
            document.getElementById('edit_usuario_referencia_id').value = usuario.referencia_id || '0';
            document.getElementById('modalEditarUsuario').style.display = 'flex';
        }

        function fecharModalEditarUsuario() {
            document.getElementById('modalEditarUsuario').style.display = 'none';
        }

        // Fechar os modais ao clicar fora deles
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCadastrarUsuario')) {
                fecharModalCadastrarUsuario();
            }
            if (event.target == document.getElementById('modalEditarUsuario')) {
                fecharModalEditarUsuario();
            }
        }
    </script>
</body>
</html>