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
            transform: translateX(0);
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .mobile-menu-close {
            display: none;
            background: none;
            border: none;
            font-size: 1.5em;
            color: #4a5568;
            cursor: pointer;
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

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.98);
            border: none;
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 1.2em;
            color: #4a5568;
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

        /* Tabela Container */
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8em;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pendente {
            background: rgba(255, 193, 7, 0.1);
            color: #ff8f00;
        }

        .status-processando {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .status-concluido {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        .itens-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .itens-list li {
            padding: 2px 0;
            font-size: 0.85em;
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
            max-width: 700px;
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

        /* Produtos no pedido */
        .produtos-container {
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: rgba(102, 126, 234, 0.02);
        }

        .produto-linha {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 15px;
            align-items: end;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .btn-add-produto {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-add-produto:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .btn-remove-produto {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9em;
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

        /* Overlay para mobile */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .mobile-menu-close {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                z-index: 1002;
            }

            .sidebar.mobile-visible {
                transform: translateX(0);
            }

            .mobile-overlay.active {
                display: block;
            }
            
            .header {
                left: 0;
                padding: 15px 70px 15px 20px;
            }

            .header-left h2 {
                font-size: 1.2em;
            }

            .user-box {
                padding: 8px 15px;
            }

            .user-box span {
                display: none;
            }
            
            .content {
                margin-left: 0;
                margin-top: 80px;
                width: 100%;
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 25px;
            }

            .page-title {
                font-size: 1.5em;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 700px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 0.8em;
            }

            .table th:first-child,
            .table td:first-child {
                padding-left: 15px;
            }

            .table th:last-child,
            .table td:last-child {
                padding-right: 15px;
            }

            .produto-linha {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
                max-height: 90vh;
            }

            .modal-title {
                font-size: 1.2em;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
            }

            .table th,
            .table td {
                padding: 8px 5px;
                font-size: 0.75em;
            }

            .modal-content {
                padding: 15px;
            }

            .form-control {
                padding: 10px 12px;
            }

            .produtos-container {
                padding: 15px;
            }

            .produto-linha {
                padding: 10px;
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
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" onclick="closeMobileMenu()"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-chart-line"></i> Gestão Full</h3>
                <button class="mobile-menu-close" onclick="closeMobileMenu()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="equipe.php"><i class="fas fa-users"></i> Equipe</a></li>
                <li><a href="pedidos.php" class="active"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
                <li><a href="produtos.php"><i class="fas fa-box"></i> Produtos</a></li>
                <li><a href="clientes.php"><i class="fas fa-user-tie"></i> Clientes</a></li>
                <li><a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-shopping-cart"></i> Gestão de Pedidos</h2>
            </div>
            <div class="user-box">
                <span><?php echo "$saudacao, $nome_usuario"; ?></span>
                <a href="?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Gerenciamento de Pedidos</h1>
                    <p class="page-subtitle">Crie e acompanhe pedidos dos seus clientes</p>
                </div>
                <button class="btn btn-primary" onclick="abrirModalCriarPedido()">
                    <i class="fas fa-plus"></i> Novo Pedido
                </button>
            </div>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas <?php echo strpos($mensagem, 'sucesso') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <!-- Tabela de pedidos -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Pedidos Realizados</h3>
                    <p class="table-count"><?php echo $result_pedidos ? $result_pedidos->num_rows : 0; ?> pedido(s) encontrado(s)</p>
                </div>

                <?php if ($result_pedidos && $result_pedidos->num_rows > 0): ?>
                    <table class="table">
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
                                    <td><strong>#<?php echo htmlspecialchars($pedido['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($pedido['cliente']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($pedido['vendedor']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($pedido['status']); ?>">
                                            <?php echo htmlspecialchars($pedido['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <ul class="itens-list">
                                            <?php foreach ($itens_pedidos[$pedido['id']] ?? [] as $item): ?>
                                                <li>
                                                    <i class="fas fa-box" style="color: #667eea; margin-right: 5px;"></i>
                                                    <?php echo htmlspecialchars($item['produto_nome']) . " (Qtd: " . htmlspecialchars($item['quantidade']) . ")"; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Nenhum pedido encontrado</h3>
                        <p>Comece criando seu primeiro pedido</p>
                        <button class="btn btn-primary" onclick="abrirModalCriarPedido()" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i> Criar Pedido
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para criar pedido -->
    <div id="modalCriarPedido" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Criar Novo Pedido</h3>
                <button class="close" onclick="fecharModalCriarPedido()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="criar_pedido">
                
                <div class="form-group">
                    <label class="form-label">Cliente *</label>
                    <select name="cliente_id" class="form-control" required>
                        <option value="">Selecione um Cliente</option>
                        <?php if ($clientes): ?>
                            <?php while ($cliente = $clientes->fetch_assoc()): ?>
                                <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nome_empresa']); ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Produtos do Pedido *</label>
                    <div class="produtos-container">
                        <div id="produtos-list">
                            <!-- Produtos serão adicionados dinamicamente -->
                        </div>
                        <button type="button" class="btn-add-produto" onclick="adicionarProduto()">
                            <i class="fas fa-plus"></i> Adicionar Produto
                        </button>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="fecharModalCriarPedido()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-save"></i> Criar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let produtoCount = 0;
        const produtosDisponiveis = [
            <?php if ($produtos): ?>
                <?php while ($produto = $produtos->fetch_assoc()): ?>
                    {
                        id: <?php echo $produto['id']; ?>,
                        nome: "<?php echo htmlspecialchars($produto['nome']); ?>",
                        codigo: "<?php echo htmlspecialchars($produto['codigo_produto']); ?>"
                    },
                <?php endwhile; ?>
            <?php endif; ?>
        ];

        // Mobile Menu Functions
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.toggle('mobile-visible');
            overlay.classList.toggle('active');
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.remove('mobile-visible');
            overlay.classList.remove('active');
        }

        // Fechar menu ao clicar em um link (mobile)
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeMobileMenu();
                }
            });
        });

        function abrirModalCriarPedido() {
            document.getElementById('modalCriarPedido').style.display = 'flex';
            // Adicionar primeiro produto automaticamente
            if (produtoCount === 0) {
                adicionarProduto();
            }
        }

        function fecharModalCriarPedido() {
            document.getElementById('modalCriarPedido').style.display = 'none';
            // Limpar produtos
            document.getElementById('produtos-list').innerHTML = '';
            produtoCount = 0;
        }

        function adicionarProduto() {
            produtoCount++;
            const produtosList = document.getElementById('produtos-list');
            
            const produtoDiv = document.createElement('div');
            produtoDiv.className = 'produto-linha';
            produtoDiv.id = `produto-${produtoCount}`;
            
            produtoDiv.innerHTML = `
                <div class="form-group">
                    <label class="form-label">Produto</label>
                    <select name="produtos[]" class="form-control" required>
                        <option value="">Selecione um Produto</option>
                        ${produtosDisponiveis.map(produto => 
                            `<option value="${produto.id}">${produto.nome} (${produto.codigo})</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantidade</label>
                    <input type="number" name="quantidades[]" class="form-control" min="1" value="1" required>
                </div>
                <div class="form-group" style="display: flex; align-items: end;">
                    <button type="button" class="btn-remove-produto" onclick="removerProduto(${produtoCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            
            produtosList.appendChild(produtoDiv);
        }

        function removerProduto(id) {
            const produtoDiv = document.getElementById(`produto-${id}`);
            if (produtoDiv) {
                produtoDiv.remove();
            }
            
            // Se não há mais produtos, adicionar um
            const produtosList = document.getElementById('produtos-list');
            if (produtosList.children.length === 0) {
                adicionarProduto();
            }
        }

        // Fechar o modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCriarPedido')) {
                fecharModalCriarPedido();
            }
        }

        // Animação suave para elementos
        document.addEventListener('DOMContentLoaded', function() {
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

        // Resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });

        // Validação do formulário
        document.querySelector('#modalCriarPedido form').addEventListener('submit', function(e) {
            const clienteSelect = document.querySelector('select[name="cliente_id"]');
            const produtoSelects = document.querySelectorAll('select[name="produtos[]"]');
            
            if (!clienteSelect.value) {
                e.preventDefault();
                alert('Por favor, selecione um cliente.');
                return;
            }
            
            let produtoSelecionado = false;
            produtoSelects.forEach(select => {
                if (select.value) {
                    produtoSelecionado = true;
                }
            });
            
            if (!produtoSelecionado) {
                e.preventDefault();
                alert('Por favor, selecione pelo menos um produto.');
                return;
            }
        });

        // Animação de carregamento no botão de submit
        document.querySelector('#modalCriarPedido form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Criando...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>
