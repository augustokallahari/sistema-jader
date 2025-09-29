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
    <title>Gestão Full - Clientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset e base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #8fa4f3 0%, #9bb5ff 50%, #a8c5ff 100%);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
            text-align: center;
        }

        .sidebar-header h3 {
            color: #4a5568;
            font-size: 1.3em;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar ul {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar ul li {
            margin: 3px 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 20px;
            position: relative;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(10px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sidebar ul li a i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 20px 30px;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            height: 80px;
        }

        .header-left h2 {
            color: #2d3748;
            font-size: 1.5em;
            font-weight: 600;
        }

        .user-box {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 12px 25px;
            border-radius: 25px;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .user-box span {
            margin-right: 15px;
            font-weight: 500;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Content */
        .content {
            margin-left: 250px;
            margin-top: 80px;
            padding: 30px;
            width: calc(100% - 250px);
            min-height: calc(100vh - 80px);
        }

        /* Page header */
        .page-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            color: #2d3748;
            font-size: 1.8em;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #718096;
            font-size: 0.95em;
            margin: 0;
        }

        /* Botões */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 0.85em;
        }

        /* Tabela Container - Corrigido */
        .table-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            margin-top: 0;
        }

        .table-header {
            padding: 25px 30px 20px 30px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
        }

        .table-title {
            color: #2d3748;
            font-size: 1.2em;
            font-weight: 600;
            margin: 0;
        }

        .table-count {
            color: #718096;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            border: none;
            font-size: 0.9em;
        }

        .table th:first-child {
            padding-left: 30px;
        }

        .table th:last-child {
            padding-right: 30px;
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.06);
            color: #4a5568;
            font-size: 0.9em;
            background: white;
        }

        .table td:first-child {
            padding-left: 30px;
        }

        .table td:last-child {
            padding-right: 30px;
        }

        .table tr:hover td {
            background: rgba(102, 126, 234, 0.03);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Estado vazio */
        .empty-state {
            text-align: center;
            padding: 60px 30px;
            color: #718096;
        }

        .empty-state i {
            font-size: 3em;
            margin-bottom: 20px;
            opacity: 0.3;
            display: block;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #4a5568;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: modalShow 0.3s ease;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
        }

        .modal-title {
            color: #2d3748;
            font-size: 1.4em;
            font-weight: 600;
        }

        .close {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(245, 101, 101, 0.1);
            color: #f56565;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .close:hover {
            background: rgba(245, 101, 101, 0.2);
            transform: scale(1.1);
        }

        /* Formulários */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.9em;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* Mensagens */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(56, 161, 105, 0.1));
            color: #2f855a;
            border-left: 4px solid #48bb78;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(245, 101, 101, 0.1), rgba(229, 62, 62, 0.1));
            color: #c53030;
            border-left: 4px solid #f56565;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .header {
                left: 0;
                position: relative;
            }
            
            .content {
                margin-left: 0;
                margin-top: 0;
                width: 100%;
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="fade-in">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-chart-line"></i> Gestão Full</h3>
            </div>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="equipe.php"><i class="fas fa-users"></i> Equipe</a></li>
                <li><a href="pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
                <li><a href="produtos.php"><i class="fas fa-box"></i> Produtos</a></li>
                <li><a href="clientes.php" class="active"><i class="fas fa-user-tie"></i> Clientes</a></li>
                <li><a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-user-tie"></i> Gestão de Clientes</h2>
            </div>
            <div class="user-box">
                <span><?php echo "$saudacao, $nome_usuario"; ?></span>
                <a href="?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Lista de Clientes</h1>
                    <p class="page-subtitle">Gerencie informações dos seus clientes</p>
                </div>
                <button class="btn btn-primary" onclick="abrirModalCadastrar()">
                    <i class="fas fa-plus"></i> Novo Cliente
                </button>
            </div>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas <?php echo strpos($mensagem, 'sucesso') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <!-- Tabela de clientes -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Clientes Cadastrados</h3>
                    <p class="table-count"><?php echo $result ? $result->num_rows : 0; ?> cliente(s) encontrado(s)</p>
                </div>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empresa</th>
                                <th>CNPJ</th>
                                <th>Responsável</th>
                                <th>Telefone</th>
                                <th>Receita Mensal</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row['nome_empresa']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['cnpj']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nome_responsavel']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                                    <td><strong>R$ <?php echo number_format($row['receita_mensal'], 2, ',', '.'); ?></strong></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="abrirModalEditar(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <form method="POST" action="" style="display:inline; margin-left: 5px;">
                                            <input type="hidden" name="acao" value="excluir">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h3>Nenhum cliente encontrado</h3>
                        <p>Comece cadastrando seu primeiro cliente</p>
                        <button class="btn btn-primary" onclick="abrirModalCadastrar()" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i> Cadastrar Cliente
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para cadastrar cliente -->
    <div id="modalCadastrar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cadastrar Novo Cliente</h3>
                <button class="close" onclick="fecharModalCadastrar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome da Empresa *</label>
                        <input type="text" name="nome_empresa" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">CNPJ *</label>
                        <input type="text" name="cnpj" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome do Responsável *</label>
                        <input type="text" name="nome_responsavel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Receita Mensal (R$)</label>
                        <input type="number" name="receita_mensal" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Produção Mensal</label>
                        <input type="number" name="producao_mensal" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Receita por Produção (R$)</label>
                    <input type="number" name="receita_producao" class="form-control" step="0.01">
                </div>

                <div class="form-group">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="endereco" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Geolocalização</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="geolocalizacao" id="geolocalizacao" class="form-control" placeholder="Latitude, Longitude">
                        <button type="button" class="btn btn-primary" onclick="capturarGeolocalizacao('geolocalizacao')">
                            <i class="fas fa-map-marker-alt"></i> Capturar
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Oportunidades</label>
                    <textarea name="oportunidades" class="form-control" placeholder="Descreva as oportunidades identificadas"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Produtos Concorrentes</label>
                    <textarea name="produtos_concorrente" class="form-control" placeholder="Liste produtos concorrentes utilizados"></textarea>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="fecharModalCadastrar()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar cliente -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Cliente</h3>
                <button class="close" onclick="fecharModalEditar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome da Empresa *</label>
                        <input type="text" name="nome_empresa" id="edit_nome_empresa" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">CNPJ *</label>
                        <input type="text" name="cnpj" id="edit_cnpj" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome do Responsável *</label>
                        <input type="text" name="nome_responsavel" id="edit_nome_responsavel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" id="edit_telefone" class="form-control">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Receita Mensal (R$)</label>
                        <input type="number" name="receita_mensal" id="edit_receita_mensal" class="form-control" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Produção Mensal</label>
                        <input type="number" name="producao_mensal" id="edit_producao_mensal" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Receita por Produção (R$)</label>
                    <input type="number" name="receita_producao" id="edit_receita_producao" class="form-control" step="0.01">
                </div>

                <div class="form-group">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="endereco" id="edit_endereco" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Geolocalização</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="geolocalizacao" id="edit_geolocalizacao" class="form-control" placeholder="Latitude, Longitude">
                        <button type="button" class="btn btn-primary" onclick="capturarGeolocalizacao('edit_geolocalizacao')">
                            <i class="fas fa-map-marker-alt"></i> Capturar
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Oportunidades</label>
                    <textarea name="oportunidades" id="edit_oportunidades" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Produtos Concorrentes</label>
                    <textarea name="produtos_concorrente" id="edit_produtos_concorrente" class="form-control"></textarea>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="fecharModalEditar()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
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
            document.getElementById('edit_telefone').value = cliente.telefone;
            document.getElementById('edit_endereco').value = cliente.endereco;
            document.getElementById('edit_geolocalizacao').value = cliente.geolocalizacao;
            document.getElementById('edit_oportunidades').value = cliente.oportunidades;
            document.getElementById('edit_produtos_concorrente').value = cliente.produtos_concorrente;
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

        // Formatação de CNPJ
        function formatarCNPJ(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 14) {
                value = value.replace(/(\d{2})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1/$2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            }
            input.value = value;
        }

        // Formatação de telefone
        function formatarTelefone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
            }
            input.value = value;
        }

        // Aplicar formatações
        document.addEventListener('DOMContentLoaded', function() {
            // CNPJ
            const cnpjInputs = document.querySelectorAll('input[name="cnpj"]');
            cnpjInputs.forEach(input => {
                input.addEventListener('input', () => formatarCNPJ(input));
            });

            // Telefone
            const telefoneInputs = document.querySelectorAll('input[name="telefone"]');
            telefoneInputs.forEach(input => {
                input.addEventListener('input', () => formatarTelefone(input));
            });

            // Animação suave para elementos
            const elements = document.querySelectorAll('.table-container, .page-header');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    element.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>
