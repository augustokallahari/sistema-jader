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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Gestão Full - Equipe</title>
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
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease;
            transform: translateX(0);
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h3 {
            color: #4a5568;
            font-size: 1.2rem;
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
            font-size: 1.5rem;
            color: #4a5568;
            cursor: pointer;
        }

        .sidebar ul {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar ul li {
            margin: 0.2rem 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 0.9rem 1rem;
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0 1.5rem 1.5rem 0;
            margin-right: 1rem;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(0.5rem);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sidebar ul li a i {
            width: 1.2rem;
            margin-right: 0.75rem;
            text-align: center;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.98);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 1.2rem;
            color: #4a5568;
            touch-action: manipulation;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 1rem 1.5rem;
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            z-index: 999;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            height: 4.5rem;
        }

        .header-left h2 {
            color: #2d3748;
            font-size: clamp(1.2rem, 3vw, 1.4rem);
            font-weight: 600;
        }

        .user-box {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 0.75rem 1.5rem;
            border-radius: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .user-box span {
            margin-right: 0.75rem;
            font-weight: 500;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Content */
        .content {
            margin-left: 260px;
            margin-top: 4.5rem;
            padding: 1.5rem;
            width: calc(100% - 260px);
            min-height: calc(100vh - 4.5rem);
        }

        /* Page header */
        .page-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .page-title {
            color: #2d3748;
            font-size: clamp(1.5rem, 4vw, 1.8rem);
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #718096;
            font-size: clamp(0.85rem, 2.5vw, 0.95rem);
            margin: 0;
        }

        /* Section Headers */
        .section-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            color: #2d3748;
            font-size: clamp(1.2rem, 3vw, 1.4rem);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Botões */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: clamp(0.85rem, 2.5vw, 0.95rem);
            touch-action: manipulation;
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
            padding: 0.5rem 1rem;
            font-size: clamp(0.75rem, 2vw, 0.85rem);
        }

        /* Tabela Container */
        .table-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            padding: 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow-x: auto;
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.9rem 1rem;
            text-align: left;
            font-weight: 600;
            border: none;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        }

        .table th:first-child {
            padding-left: 1.5rem;
        }

        .table th:last-child {
            padding-right: 1.5rem;
        }

        .table td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.06);
            color: #4a5568;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            background: white;
        }

        .table td:first-child {
            padding-left: 1.5rem;
        }

        .table td:last-child {
            padding-right: 1.5rem;
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
            padding: 3rem 1rem;
            color: #718096;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.3;
            display: block;
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-size: clamp(1.1rem, 3vw, 1.3rem);
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
            border-radius: 1rem;
            padding: 1.5rem;
            width: min(90%, 600px);
            max-height: 90vh;
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
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
        }

        .modal-title {
            color: #2d3748;
            font-size: clamp(1.2rem, 3vw, 1.4rem);
            font-weight: 600;
        }

        .close {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: rgba(245, 101, 101, 0.1);
            color: #f56565;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .close:hover {
            background: rgba(245, 101, 101, 0.2);
            transform: scale(1.1);
        }

        /* Formulários */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 0.75rem;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
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
            min-height: 5rem;
        }

        /* Mensagens */
        .alert {
            padding: 0.9rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;
                width: calc(100% - 220px);
            }

            .header {
                left: 220px;
            }
        }

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
                width: 70vw;
                max-width: 300px;
            }

            .sidebar.mobile-visible {
                transform: translateX(0);
            }

            .mobile-overlay.active {
                display: block;
            }

            .header {
                left: 0;
                padding: 1rem 4rem 1rem 1rem;
            }

            .header-left h2 {
                font-size: clamp(1rem, 3vw, 1.2rem);
            }

            .user-box {
                padding: 0.5rem 1rem;
            }

            .user-box span {
                display: none;
            }

            .content {
                margin-left: 0;
                margin-top: 4.5rem;
                width: 100%;
                padding: 1rem;
            }

            .page-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .page-title {
                font-size: clamp(1.3rem, 4vw, 1.5rem);
            }

            .section-header {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
                padding: 1rem;
            }

            .section-title {
                font-size: clamp(1rem, 3vw, 1.2rem);
            }

            .table-container {
                margin-bottom: 1.5rem;
                overflow-x: auto;
            }

            .table {
                min-width: 600px;
            }

            .table th,
            .table td {
                padding: 0.6rem 0.5rem;
                font-size: clamp(0.75rem, 2.5vw, 0.8rem);
            }

            .table th:first-child,
            .table td:first-child {
                padding-left: 0.75rem;
            }

            .table th:last-child,
            .table td:last-child {
                padding-right: 0.75rem;
            }

            .btn-sm {
                padding: 0.4rem 0.75rem;
                font-size: clamp(0.7rem, 2vw, 0.75rem);
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .modal-content {
                width: 95%;
                padding: 1rem;
                max-height: 90vh;
            }

            .modal-title {
                font-size: clamp(1rem, 3vw, 1.2rem);
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state i {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 0.75rem;
            }

            .page-header {
                padding: 0.75rem;
            }

            .section-header {
                padding: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.5rem 0.3rem;
                font-size: clamp(0.7rem, 2.5vw, 0.75rem);
            }

            .btn {
                padding: 0.5rem 0.75rem;
                font-size: clamp(0.8rem, 2.5vw, 0.85rem);
            }

            .btn-sm {
                padding: 0.3rem 0.5rem;
                font-size: clamp(0.65rem, 2vw, 0.7rem);
            }

            .modal-content {
                padding: 0.75rem;
            }

            .form-control {
                padding: 0.6rem 0.75rem;
                font-size: clamp(0.85rem, 2.5vw, 0.9rem);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(1rem);
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
                <li><a href="equipe.php" class="active"><i class="fas fa-users"></i> Equipe</a></li>
                <li><a href="pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
                <li><a href="produtos.php"><i class="fas fa-box"></i> Produtos</a></li>
                <li><a href="clientes.php"><i class="fas fa-user-tie"></i> Clientes</a></li>
                <li><a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-users"></i> Gestão de Equipe</h2>
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
                <h1 class="page-title">Gerenciamento de Equipe</h1>
                <p class="page-subtitle">Gerencie gerentes e vendedores da sua empresa</p>
            </div>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas <?php echo strpos($mensagem, 'sucesso') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <!-- Seção de Gerentes -->
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-user-tie"></i> Gerentes
                </h3>
                <button class="btn btn-primary" onclick="abrirModalCadastrarGerente()">
                    <i class="fas fa-plus"></i> Novo Gerente
                </button>
            </div>

            <div class="table-container">
                <?php if ($result_gerentes && $result_gerentes->num_rows > 0): ?>
                    <table class="table">
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
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row['nome']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['foco']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dados_reuniao']); ?></td>
                                    <td><?php echo htmlspecialchars($row['observacao']); ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="abrirModalEditarGerente(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-edit"></i> <span class="btn-text">Editar</span>
                                        </button>
                                        <form method="POST" action="" style="display:inline; margin-left: 0.3rem;">
                                            <input type="hidden" name="acao" value="excluir_gerente">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este gerente?')">
                                                <i class="fas fa-trash"></i> <span class="btn-text">Excluir</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-user-tie"></i>
                        <h3>Nenhum gerente encontrado</h3>
                        <p>Comece cadastrando seu primeiro gerente</p>
                        <button class="btn btn-primary" onclick="abrirModalCadastrarGerente()" style="margin-top: 1rem;">
                            <i class="fas fa-plus"></i> Cadastrar Gerente
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Seção de Vendedores -->
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-handshake"></i> Vendedores
                </h3>
                <button class="btn btn-primary" onclick="abrirModalCadastrarVendedor()">
                    <i class="fas fa-plus"></i> Novo Vendedor
                </button>
            </div>

            <div class="table-container">
                <?php if ($result_vendedores && $result_vendedores->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Foco</th>
                                <th>Gerente</th>
                                <th>Observação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_vendedores->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row['nome']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['foco']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gerente_nome'] ?: 'Não atribuído'); ?></td>
                                    <td><?php echo htmlspecialchars($row['observacao']); ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="abrirModalEditarVendedor(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-edit"></i> <span class="btn-text">Editar</span>
                                        </button>
                                        <form method="POST" action="" style="display:inline; margin-left: 0.3rem;">
                                            <input type="hidden" name="acao" value="excluir_vendedor">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')">
                                                <i class="fas fa-trash"></i> <span class="btn-text">Excluir</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-handshake"></i>
                        <h3>Nenhum vendedor encontrado</h3>
                        <p>Comece cadastrando seu primeiro vendedor</p>
                        <button class="btn btn-primary" onclick="abrirModalCadastrarVendedor()" style="margin-top: 1rem;">
                            <i class="fas fa-plus"></i> Cadastrar Vendedor
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para cadastrar gerente -->
    <div id="modalCadastrarGerente" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cadastrar Novo Gerente</h3>
                <button class="close" onclick="fecharModalCadastrarGerente()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_gerente">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="telefone" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Foco</label>
                    <input type="text" name="foco" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Dados Reunião</label>
                    <textarea name="dados_reuniao" class="form-control" placeholder="Informações sobre reuniões"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Observação</label>
                    <textarea name="observacao" class="form-control" placeholder="Observações gerais"></textarea>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar gerente -->
    <div id="modalEditarGerente" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Gerente</h3>
                <button class="close" onclick="fecharModalEditarGerente()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_gerente">
                <input type="hidden" name="id" id="edit_gerente_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" id="edit_gerente_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="telefone" id="edit_gerente_telefone" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Foco</label>
                    <input type="text" name="foco" id="edit_gerente_foco" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Dados Reunião</label>
                    <textarea name="dados_reuniao" id="edit_gerente_dados_reuniao" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Observação</label>
                    <textarea name="observacao" id="edit_gerente_observacao" class="form-control"></textarea>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para cadastrar vendedor -->
    <div id="modalCadastrarVendedor" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cadastrar Novo Vendedor</h3>
                <button class="close" onclick="fecharModalCadastrarVendedor()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_vendedor">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="telefone" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Foco</label>
                        <input type="text" name="foco" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gerente Responsável *</label>
                        <select name="gerente_id" class="form-control" required>
                            <option value="">Selecione um Gerente</option>
                            <?php if ($gerentes): ?>
                                <?php while ($gerente = $gerentes->fetch_assoc()): ?>
                                    <option value="<?php echo $gerente['id']; ?>"><?php echo htmlspecialchars($gerente['nome']); ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Observação</label>
                    <textarea name="observacao" class="form-control" placeholder="Observações gerais"></textarea>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar vendedor -->
    <div id="modalEditarVendedor" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Vendedor</h3>
                <button class="close" onclick="fecharModalEditarVendedor()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_vendedor">
                <input type="hidden" name="id" id="edit_vendedor_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" id="edit_vendedor_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="telefone" id="edit_vendedor_telefone" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Foco</label>
                        <input type="text" name="foco" id="edit_vendedor_foco" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gerente Responsável *</label>
                        <select name="gerente_id" id="edit_vendedor_gerente_id" class="form-control" required>
                            <option value="">Selecione um Gerente</option>
                            <?php if ($gerentes): ?>
                                <?php $gerentes->data_seek(0); while ($gerente = $gerentes->fetch_assoc()): ?>
                                    <option value="<?php echo $gerente['id']; ?>"><?php echo htmlspecialchars($gerente['nome']); ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Observação</label>
                    <textarea name="observacao" id="edit_vendedor_observacao" class="form-control"></textarea>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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

        // Funções para Gerentes
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

        // Funções para Vendedores
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
            const modals = ['modalCadastrarGerente', 'modalEditarGerente', 'modalCadastrarVendedor', 'modalEditarVendedor'];
            modals.forEach(modalId => {
                if (event.target == document.getElementById(modalId)) {
                    document.getElementById(modalId).style.display = 'none';
                }
            });
        }

        // Animação suave para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.table-container, .page-header, .section-header');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(1rem)';
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

        // Esconder texto dos botões em telas muito pequenas
        function updateButtonText() {
            const btnTexts = document.querySelectorAll('.btn-text');
            if (window.innerWidth <= 480) {
                btnTexts.forEach(text => text.style.display = 'none');
            } else {
                btnTexts.forEach(text => text.style.display = 'inline');
            }
        }

        window.addEventListener('resize', updateButtonText);
        document.addEventListener('DOMContentLoaded', updateButtonText);
    </script>
</body>
</html>
