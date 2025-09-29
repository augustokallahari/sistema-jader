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

        .permission-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .permission-adm {
            background: linear-gradient(135deg, rgba(245, 101, 101, 0.15), rgba(229, 62, 62, 0.15));
            color: #c53030;
            border: 1px solid rgba(245, 101, 101, 0.3);
        }

        .permission-user {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15));
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .password-display {
            font-family: monospace;
            background: rgba(102, 126, 234, 0.05);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.85em;
            color: #4a5568;
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

        /* Security Section */
        .security-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 152, 0, 0.1));
            border-left: 4px solid #ffc107;
            color: #e65100;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .security-warning i {
            font-size: 1.5em;
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
                min-width: 800px;
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

            .btn-sm {
                padding: 6px 10px;
                font-size: 0.75em;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
                max-height: 90vh;
            }

            .modal-title {
                font-size: 1.2em;
            }

            .permission-badge {
                font-size: 0.7em;
                padding: 4px 8px;
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

            .password-display {
                font-size: 0.7em;
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
                <li><a href="pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
                <li><a href="produtos.php"><i class="fas fa-box"></i> Produtos</a></li>
                <li><a href="clientes.php"><i class="fas fa-user-tie"></i> Clientes</a></li>
                <li><a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php" class="active"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-cog"></i> Configurações do Sistema</h2>
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
                    <h1 class="page-title">Gerenciamento de Usuários</h1>
                    <p class="page-subtitle">Configure usuários e permissões do sistema</p>
                </div>
                <button class="btn btn-primary" onclick="abrirModalCadastrarUsuario()">
                    <i class="fas fa-user-plus"></i> Novo Usuário
                </button>
            </div>

            <!-- Security Warning -->
            <div class="security-warning">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>Aviso de Segurança:</strong> Esta seção permite gerenciar usuários e permissões do sistema. Tenha cuidado ao alterar permissões, pois isso pode afetar o acesso de outros usuários.
                </div>
            </div>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas <?php echo strpos($mensagem, 'sucesso') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <!-- Tabela de usuários -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Usuários do Sistema</h3>
                    <p class="table-count"><?php echo $result ? $result->num_rows : 0; ?> usuário(s) cadastrado(s)</p>
                </div>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table">
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
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row['nome']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <span class="password-display">
                                            <?php echo str_repeat('●', min(strlen($row['senha']), 8)); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="permission-badge permission-<?php echo htmlspecialchars($row['permissao']); ?>">
                                            <?php echo $row['permissao'] === 'adm' ? 'Administrador' : 'Usuário'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['referencia_id']): ?>
                                            <i class="fas fa-link" style="color: #667eea; margin-right: 5px;"></i>
                                            Equipe ID: <?php echo htmlspecialchars($row['referencia_id']); ?>
                                        <?php else: ?>
                                            <span style="color: #718096; font-style: italic;">Sem referência</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="abrirModalEditarUsuario(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-edit"></i> <span class="btn-text">Editar</span>
                                        </button>
                                        <form method="POST" action="" style="display:inline; margin-left: 5px;">
                                            <input type="hidden" name="acao" value="excluir_usuario">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
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
                        <i class="fas fa-users-cog"></i>
                        <h3>Nenhum usuário encontrado</h3>
                        <p>Comece cadastrando o primeiro usuário do sistema</p>
                        <button class="btn btn-primary" onclick="abrirModalCadastrarUsuario()" style="margin-top: 20px;">
                            <i class="fas fa-user-plus"></i> Cadastrar Usuário
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para cadastrar usuário -->
    <div id="modalCadastrarUsuario" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cadastrar Novo Usuário</h3>
                <button class="close" onclick="fecharModalCadastrarUsuario()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="cadastrar_usuario">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="usuario@email.com" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Senha *</label>
                        <input type="password" name="senha" class="form-control" placeholder="Digite uma senha segura" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nível de Permissão *</label>
                        <select name="permissao" class="form-control" required>
                            <option value="">Selecione a Permissão</option>
                            <option value="adm">👑 Administrador (Controle Total)</option>
                            <option value="user">👤 Usuário (Apenas Clientes)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Referência da Equipe</label>
                    <select name="referencia_id" class="form-control">
                        <option value="">Sem Referência</option>
                        <?php if ($equipe): ?>
                            <?php while ($membro = $equipe->fetch_assoc()): ?>
                                <option value="<?php echo $membro['id']; ?>">
                                    <?php echo htmlspecialchars($membro['nome']); ?> (<?php echo ucfirst($membro['tipo']); ?>)
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                    <small style="color: #718096; font-size: 0.85em; margin-top: 5px; display: block;">
                        <i class="fas fa-info-circle"></i> Opcional: Vincule o usuário a um membro da equipe
                    </small>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="fecharModalCadastrarUsuario()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar usuário -->
    <div id="modalEditarUsuario" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Usuário</h3>
                <button class="close" onclick="fecharModalEditarUsuario()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar_usuario">
                <input type="hidden" name="id" id="edit_usuario_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome" id="edit_usuario_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" id="edit_usuario_email" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nova Senha *</label>
                        <input type="password" name="senha" id="edit_usuario_senha" class="form-control" required>
                        <small style="color: #718096; font-size: 0.85em; margin-top: 5px; display: block;">
                            <i class="fas fa-key"></i> Digite uma nova senha para o usuário
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nível de Permissão *</label>
                        <select name="permissao" id="edit_usuario_permissao" class="form-control" required>
                            <option value="">Selecione a Permissão</option>
                            <option value="adm">👑 Administrador (Controle Total)</option>
                            <option value="user">👤 Usuário (Apenas Clientes)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Referência da Equipe</label>
                    <select name="referencia_id" id="edit_usuario_referencia_id" class="form-control">
                        <option value="">Sem Referência</option>
                        <?php if ($equipe): ?>
                            <?php $equipe->data_seek(0); while ($membro = $equipe->fetch_assoc()): ?>
                                <option value="<?php echo $membro['id']; ?>">
                                    <?php echo htmlspecialchars($membro['nome']); ?> (<?php echo ucfirst($membro['tipo']); ?>)
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="fecharModalEditarUsuario()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-save"></i> Salvar Alterações
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

        function abrirModalCadastrarUsuario() {
            document.getElementById('modalCadastrarUsuario').style.display = 'flex';
        }

        function fecharModalCadastrarUsuario() {
            document.getElementById('modalCadastrarUsuario').style.display = 'none';
            // Limpar formulário
            document.querySelector('#modalCadastrarUsuario form').reset();
        }

        function abrirModalEditarUsuario(usuario) {
            document.getElementById('edit_usuario_id').value = usuario.id;
            document.getElementById('edit_usuario_nome').value = usuario.nome;
            document.getElementById('edit_usuario_email').value = usuario.email;
            document.getElementById('edit_usuario_senha').value = usuario.senha;
            document.getElementById('edit_usuario_permissao').value = usuario.permissao;
            document.getElementById('edit_usuario_referencia_id').value = usuario.referencia_id || '';
            document.getElementById('modalEditarUsuario').style.display = 'flex';
        }

        function fecharModalEditarUsuario() {
            document.getElementById('modalEditarUsuario').style.display = 'none';
        }

        // Fechar os modais ao clicar fora deles
        window.onclick = function(event) {
            const modals = ['modalCadastrarUsuario', 'modalEditarUsuario'];
            modals.forEach(modalId => {
                if (event.target == document.getElementById(modalId)) {
                    document.getElementById(modalId).style.display = 'none';
                }
            });
        }

        // Validação de email
        function validarEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Validação de senha
        function validarSenha(senha) {
            return senha.length >= 6;
        }

        // Validação do formulário de cadastro
        document.querySelector('#modalCadastrarUsuario form').addEventListener('submit', function(e) {
            const nome = this.querySelector('input[name="nome"]').value;
            const email = this.querySelector('input[name="email"]').value;
            const senha = this.querySelector('input[name="senha"]').value;
            const permissao = this.querySelector('select[name="permissao"]').value;
            
            if (!nome.trim()) {
                e.preventDefault();
                alert('Por favor, digite o nome completo.');
                return;
            }
            
            if (!validarEmail(email)) {
                e.preventDefault();
                alert('Por favor, digite um email válido.');
                return;
            }
            
            if (!validarSenha(senha)) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres.');
                return;
            }
            
            if (!permissao) {
                e.preventDefault();
                alert('Por favor, selecione o nível de permissão.');
                return;
            }
        });

        // Validação do formulário de edição
        document.querySelector('#modalEditarUsuario form').addEventListener('submit', function(e) {
            const nome = this.querySelector('input[name="nome"]').value;
            const email = this.querySelector('input[name="email"]').value;
            const senha = this.querySelector('input[name="senha"]').value;
            const permissao = this.querySelector('select[name="permissao"]').value;
            
            if (!nome.trim()) {
                e.preventDefault();
                alert('Por favor, digite o nome completo.');
                return;
            }
            
            if (!validarEmail(email)) {
                e.preventDefault();
                alert('Por favor, digite um email válido.');
                return;
            }
            
            if (!validarSenha(senha)) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres.');
                return;
            }
            
            if (!permissao) {
                e.preventDefault();
                alert('Por favor, selecione o nível de permissão.');
                return;
            }
        });

        // Animação suave para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.table-container, .page-header, .security-warning');
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

        // Efeito de loading nos botões de submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Indicador de força da senha
        function verificarForcaSenha(senha) {
            let forca = 0;
            if (senha.length >= 8) forca++;
            if (/[a-z]/.test(senha)) forca++;
            if (/[A-Z]/.test(senha)) forca++;
            if (/[0-9]/.test(senha)) forca++;
            if (/[^A-Za-z0-9]/.test(senha)) forca++;
            
            return forca;
        }

        // Adicionar indicador de força da senha
        document.querySelectorAll('input[type="password"]').forEach(input => {
            input.addEventListener('input', function() {
                const forca = verificarForcaSenha(this.value);
                let cor = '#f56565';
                let texto = 'Fraca';
                
                if (forca >= 3) {
                    cor = '#ffc107';
                    texto = 'Média';
                }
                if (forca >= 4) {
                    cor = '#48bb78';
                    texto = 'Forte';
                }
                
                // Remover indicador anterior
                const indicadorAnterior = this.parentElement.querySelector('.password-strength');
                if (indicadorAnterior) {
                    indicadorAnterior.remove();
                }
                
                // Adicionar novo indicador se há senha
                if (this.value.length > 0) {
                    const indicador = document.createElement('small');
                    indicador.className = 'password-strength';
                    indicador.style.color = cor;
                    indicador.style.fontSize = '0.8em';
                    indicador.style.marginTop = '5px';
                    indicador.style.display = 'block';
                    indicador.innerHTML = `<i class="fas fa-shield-alt"></i> Senha ${texto}`;
                    this.parentElement.appendChild(indicador);
                }
            });
        });
    </script>
</body>
</html>
