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
    <title>Gestão Full - Produtos</title>
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

        /* Form Container para cadastro rápido */
        .quick-form {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 25px;
        }

        .quick-form h3 {
            color: #2d3748;
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
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

        .product-code {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 500;
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
            max-width: 500px;
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

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
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
                <li><a href="produtos.php" class="active"><i class="fas fa-box"></i> Produtos</a></li>
                <li><a href="clientes.php"><i class="fas fa-user-tie"></i> Clientes</a></li>
                <li><a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-box"></i> Gestão de Produtos</h2>
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
                    <h1 class="page-title">Catálogo de Produtos</h1>
                    <p class="page-subtitle">Gerencie o catálogo de produtos da sua empresa</p>
                </div>
            </div>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <i class="fas <?php echo strpos($mensagem, 'sucesso') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>

            <!-- Formulário de cadastro rápido -->
            <div class="quick-form">
                <h3><i class="fas fa-plus-circle"></i> Cadastrar Novo Produto</h3>
                <form method="POST" action="">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nome do Produto</label>
                            <input type="text" name="nome" class="form-control" placeholder="Digite o nome do produto" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Código do Produto</label>
                            <input type="text" name="codigo_produto" class="form-control" placeholder="Ex: PRD001" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Cadastrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabela de produtos -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Produtos Cadastrados</h3>
                    <p class="table-count"><?php echo $result ? $result->num_rows : 0; ?> produto(s) cadastrado(s)</p>
                </div>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Produto</th>
                                <th>Código</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row['nome']); ?></strong></td>
                                    <td>
                                        <span class="product-code">
                                            <?php echo htmlspecialchars($row['codigo_produto']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="abrirModalEditar(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nome']); ?>', '<?php echo htmlspecialchars($row['codigo_produto']); ?>')">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <form method="POST" action="" style="display:inline; margin-left: 5px;">
                                            <input type="hidden" name="acao" value="excluir">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
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
                        <i class="fas fa-box"></i>
                        <h3>Nenhum produto encontrado</h3>
                        <p>Comece cadastrando seu primeiro produto</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para editar produto -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Produto</h3>
                <button class="close" onclick="fecharModalEditar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label class="form-label">Nome do Produto *</label>
                    <input type="text" name="nome" id="edit_nome" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Código do Produto *</label>
                    <input type="text" name="codigo_produto" id="edit_codigo_produto" class="form-control" required>
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

        // Animação suave para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.table-container, .page-header, .quick-form');
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
