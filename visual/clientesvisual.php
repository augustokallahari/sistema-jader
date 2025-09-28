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

        .modal-content input, .modal-content textarea {
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
        <h2>Lista de Clientes</h2>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Botão para abrir o modal de cadastro -->
        <button class="add-btn" onclick="abrirModalCadastrar()">Cadastrar Novo Cliente</button>

        <!-- Tabela de clientes -->
        <?php if ($result): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Empresa</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Receita Mensal</th>
                        <th>Produção Mensal</th>
                        <th>Receita/Produção</th>
                        <th>Oportunidades</th>
                        <th>Produtos Concorrentes</th>
                        <th>Endereço</th>
                        <th>Geolocalização</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_empresa']); ?></td>
                            <td><?php echo htmlspecialchars($row['cnpj']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_responsavel']); ?></td>
                            <td><?php echo htmlspecialchars($row['receita_mensal']); ?></td>
                            <td><?php echo htmlspecialchars($row['producao_mensal']); ?></td>
                            <td><?php echo htmlspecialchars($row['receita_producao']); ?></td>
                            <td><?php echo htmlspecialchars($row['oportunidades']); ?></td>
                            <td><?php echo htmlspecialchars($row['produtos_concorrente']); ?></td>
                            <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($row['geolocalizacao']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="abrirModalEditar(<?php echo htmlspecialchars(json_encode($row)); ?>)">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum cliente encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para cadastrar cliente -->
    <div id="modalCadastrar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalCadastrar()">&times;</span>
            <h3>Cadastrar Novo Cliente</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar">
                <input type="text" name="nome_empresa" placeholder="Nome da Empresa" required>
                <input type="text" name="cnpj" placeholder="CNPJ" required>
                <input type="text" name="nome_responsavel" placeholder="Nome do Responsável" required>
                <input type="number" name="receita_mensal" placeholder="Receita Mensal (R$)" step="0.01">
                <input type="number" name="producao_mensal" placeholder="Produção Mensal">
                <input type="number" name="receita_producao" placeholder="Receita por Produção (R$)" step="0.01">
                <textarea name="oportunidades" placeholder="Oportunidades"></textarea>
                <textarea name="produtos_concorrente" placeholder="Produtos Concorrentes"></textarea>
                <input type="text" name="endereco" placeholder="Endereço">
                <input type="text" name="geolocalizacao" id="geolocalizacao" placeholder="Geolocalização (lat,long)">
                <button type="button" onclick="capturarGeolocalizacao('geolocalizacao')">Capturar Geolocalização</button>
                <input type="text" name="telefone" placeholder="Telefone">
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <!-- Modal para editar cliente -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditar()">&times;</span>
            <h3>Editar Cliente</h3>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="nome_empresa" id="edit_nome_empresa" placeholder="Nome da Empresa" required>
                <input type="text" name="cnpj" id="edit_cnpj" placeholder="CNPJ" required>
                <input type="text" name="nome_responsavel" id="edit_nome_responsavel" placeholder="Nome do Responsável" required>
                <input type="number" name="receita_mensal" id="edit_receita_mensal" placeholder="Receita Mensal (R$)" step="0.01">
                <input type="number" name="producao_mensal" id="edit_producao_mensal" placeholder="Produção Mensal">
                <input type="number" name="receita_producao" id="edit_receita_producao" placeholder="Receita por Produção (R$)" step="0.01">
                <textarea name="oportunidades" id="edit_oportunidades" placeholder="Oportunidades"></textarea>
                <textarea name="produtos_concorrente" id="edit_produtos_concorrente" placeholder="Produtos Concorrentes"></textarea>
                <input type="text" name="endereco" id="edit_endereco" placeholder="Endereço">
                <input type="text" name="geolocalizacao" id="edit_geolocalizacao" placeholder="Geolocalização (lat,long)">
                <button type="button" onclick="capturarGeolocalizacao('edit_geolocalizacao')">Capturar Geolocalização</button>
                <input type="text" name="telefone" id="edit_telefone" placeholder="Telefone">
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        function capturarGeolocalizacao(campoId = 'geolocalizacao') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        document.getElementById(campoId).value = `${lat},${lon}`;
                    },
                    function(error) {
                        alert('Erro ao capturar geolocalização: ' + error.message);
                    }
                );
            } else {
                alert('Geolocalização não é suportada por este navegador.');
            }
        }

        function abrirModalCadastrar() {
            document.getElementById('modalCadastrar').style.display = 'flex';
        }

        function fecharModalCadastrar() {
            document.getElementById('modalCadastrar').style.display = 'none';
        }

        function abrirModalEditar(cliente) {
            document.getElementById('edit_id').value = cliente.id;
            document.getElementById('edit_nome_empresa').value = cliente.nome_empresa;
            document.getElementById('edit_cnpj').value = cliente.cnpj;
            document.getElementById('edit_nome_responsavel').value = cliente.nome_responsavel;
            document.getElementById('edit_receita_mensal').value = cliente.receita_mensal;
            document.getElementById('edit_producao_mensal').value = cliente.producao_mensal;
            document.getElementById('edit_receita_producao').value = cliente.receita_producao;
            document.getElementById('edit_oportunidades').value = cliente.oportunidades;
            document.getElementById('edit_produtos_concorrente').value = cliente.produtos_concorrente;
            document.getElementById('edit_endereco').value = cliente.endereco;
            document.getElementById('edit_geolocalizacao').value = cliente.geolocalizacao;
            document.getElementById('edit_telefone').value = cliente.telefone;
            document.getElementById('modalEditar').style.display = 'flex';
        }

        function fecharModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        // Fechar os modais ao clicar fora deles
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCadastrar')) {
                fecharModalCadastrar();
            }
            if (event.target == document.getElementById('modalEditar')) {
                fecharModalEditar();
            }
        }
    </script>
</body>
</html>