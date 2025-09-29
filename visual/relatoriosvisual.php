<?php
// Receber variáveis do backend
$saudacao = isset($saudacao) ? $saudacao : "Olá";
$nome_usuario = isset($nome_usuario) ? $nome_usuario : "Usuário";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full - Relatórios</title>
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
            margin-bottom: 30px;
            text-align: center;
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

        /* Reports Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .report-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .report-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .report-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .report-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            flex-shrink: 0;
        }

        .report-info {
            flex: 1;
            margin-left: 20px;
        }

        .report-title {
            color: #2d3748;
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .report-description {
            color: #718096;
            font-size: 0.9em;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .report-features {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .report-features li {
            padding: 5px 0;
            color: #4a5568;
            font-size: 0.85em;
            display: flex;
            align-items: center;
        }

        .report-features li i {
            width: 16px;
            color: #48bb78;
            margin-right: 8px;
        }

        .report-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9em;
            flex: 1;
            justify-content: center;
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

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #4a5568;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }

        /* Quick Stats Section */
        .quick-stats {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
        }

        .quick-stats h3 {
            color: #2d3748;
            font-size: 1.4em;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #4a5568;
            font-size: 0.9em;
            font-weight: 500;
        }

        /* Coming Soon Badge */
        .coming-soon {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.7em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-card.disabled {
            opacity: 0.7;
        }

        .report-card.disabled:hover {
            transform: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
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
                padding: 25px;
                margin-bottom: 25px;
            }

            .page-title {
                font-size: 1.5em;
            }

            .reports-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .report-card {
                padding: 25px;
            }

            .report-header {
                flex-direction: column;
                text-align: center;
            }

            .report-info {
                margin-left: 0;
                margin-top: 15px;
            }

            .report-actions {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-item {
                padding: 15px;
            }

            .stat-number {
                font-size: 1.5em;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
            }

            .report-card {
                padding: 20px;
            }

            .report-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3em;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-stats {
                padding: 20px;
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
                <li><a href="relatorios.php" class="active"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h2><i class="fas fa-chart-bar"></i> Central de Relatórios</h2>
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
                <h1 class="page-title">Central de Relatórios</h1>
                <p class="page-subtitle">Analise o desempenho e gere insights para seu negócio</p>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <h3><i class="fas fa-tachometer-alt"></i> Visão Geral Rápida</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">42</div>
                        <div class="stat-label">Total de Clientes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">128</div>
                        <div class="stat-label">Pedidos Realizados</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">R$ 89.5K</div>
                        <div class="stat-label">Receita Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Membros da Equipe</div>
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="reports-grid">
                <!-- Relatório de Vendas -->
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Relatório de Vendas</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Análise completa das vendas por período, vendedor e produto. Inclui métricas de performance e comparativos.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Vendas por período</li>
                        <li><i class="fas fa-check"></i> Performance por vendedor</li>
                        <li><i class="fas fa-check"></i> Produtos mais vendidos</li>
                        <li><i class="fas fa-check"></i> Comparativo mensal</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="gerarRelatorio('vendas')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-secondary" onclick="exportarRelatorio('vendas')">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Relatório de Clientes -->
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Relatório de Clientes</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Informações detalhadas sobre a base de clientes, segmentação e oportunidades de crescimento.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Dados dos clientes</li>
                        <li><i class="fas fa-check"></i> Segmentação por região</li>
                        <li><i class="fas fa-check"></i> Histórico de compras</li>
                        <li><i class="fas fa-check"></i> Oportunidades identificadas</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="gerarRelatorio('clientes')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-secondary" onclick="exportarRelatorio('clientes')">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Relatório Financeiro -->
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Relatório Financeiro</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Análise financeira completa com receitas, custos, margem de lucro e projeções futuras.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Receitas e despesas</li>
                        <li><i class="fas fa-check"></i> Margem de lucro</li>
                        <li><i class="fas fa-check"></i> Fluxo de caixa</li>
                        <li><i class="fas fa-check"></i> Projeções</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="gerarRelatorio('financeiro')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-secondary" onclick="exportarRelatorio('financeiro')">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Relatório de Equipe -->
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Performance da Equipe</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Avaliação de performance da equipe de vendas, metas atingidas e áreas de melhoria.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Performance individual</li>
                        <li><i class="fas fa-check"></i> Metas vs realizações</li>
                        <li><i class="fas fa-check"></i> Ranking de vendedores</li>
                        <li><i class="fas fa-check"></i> Análise de produtividade</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="gerarRelatorio('equipe')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-secondary" onclick="exportarRelatorio('equipe')">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Relatório de Produtos -->
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Análise de Produtos</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Desempenho dos produtos, análise de demanda e recomendações de estoque.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Produtos mais vendidos</li>
                        <li><i class="fas fa-check"></i> Análise de demanda</li>
                        <li><i class="fas fa-check"></i> Rotatividade de estoque</li>
                        <li><i class="fas fa-check"></i> Produtos em baixa</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="gerarRelatorio('produtos')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-secondary" onclick="exportarRelatorio('produtos')">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Relatório Personalizado - Coming Soon -->
                <div class="report-card disabled">
                    <div class="coming-soon">Em Breve</div>
                    <div class="report-header">
                        <div class="report-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="report-info">
                            <h3 class="report-title">Relatórios Personalizados</h3>
                        </div>
                    </div>
                    <p class="report-description">
                        Crie relatórios customizados com os dados que você precisa, do jeito que você quer.
                    </p>
                    <ul class="report-features">
                        <li><i class="fas fa-check"></i> Campos personalizáveis</li>
                        <li><i class="fas fa-check"></i> Filtros avançados</li>
                        <li><i class="fas fa-check"></i> Agendamento automático</li>
                        <li><i class="fas fa-check"></i> Múltiplos formatos</li>
                    </ul>
                    <div class="report-actions">
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-clock"></i> Em Desenvolvimento
                        </button>
                    </div>
                </div>
            </div>
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

        // Função para gerar relatórios
        function gerarRelatorio(tipo) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            // Mostrar loading
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Gerando...';
            btn.disabled = true;
            
            // Simular processamento
            setTimeout(() => {
                // Aqui você pode adicionar a lógica real para gerar o relatório
                // Por exemplo, fazer uma requisição AJAX para o backend
                
                // Simulação de sucesso
                btn.innerHTML = '<i class="fas fa-check"></i> Gerado!';
                btn.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
                
                // Mostrar dados do relatório (simulação)
                mostrarPreviewRelatorio(tipo);
                
                // Restaurar botão após 2 segundos
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.style.background = '';
                }, 2000);
            }, 2000);
        }

        // Função para exportar relatórios
        function exportarRelatorio(tipo) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            // Mostrar loading
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
            btn.disabled = true;
            
            // Simular processamento
            setTimeout(() => {
                // Aqui você pode adicionar a lógica real para exportar
                // Por exemplo, gerar PDF ou Excel
                
                // Simulação de download
                btn.innerHTML = '<i class="fas fa-download"></i> Baixando...';
                
                // Criar link de download simulado
                const link = document.createElement('a');
                link.href = '#';
                link.download = `relatorio_${tipo}_${new Date().toISOString().split('T')[0]}.pdf`;
                
                // Simular download
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-check"></i> Exportado!';
                    btn.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
                    
                    // Notificação de sucesso
                    mostrarNotificacao(`Relatório de ${tipo} exportado com sucesso!`, 'success');
                    
                    // Restaurar botão
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        btn.style.background = '';
                    }, 2000);
                }, 1000);
            }, 1500);
        }

        // Função para mostrar preview do relatório
        function mostrarPreviewRelatorio(tipo) {
            let dadosRelatorio = '';
            
            switch(tipo) {
                case 'vendas':
                    dadosRelatorio = `
                        <h4>📊 Relatório de Vendas - ${new Date().toLocaleDateString()}</h4>
                        <p><strong>Total de Vendas:</strong> R$ 45.280,00</p>
                        <p><strong>Pedidos:</strong> 23 pedidos realizados</p>
                        <p><strong>Ticket Médio:</strong> R$ 1.968,70</p>
                        <p><strong>Crescimento:</strong> +15% vs mês anterior</p>
                    `;
                    break;
                case 'clientes':
                    dadosRelatorio = `
                        <h4>👥 Relatório de Clientes - ${new Date().toLocaleDateString()}</h4>
                        <p><strong>Total de Clientes:</strong> 42 clientes ativos</p>
                        <p><strong>Novos Clientes:</strong> 5 este mês</p>
                        <p><strong>Taxa de Retenção:</strong> 85%</p>
                        <p><strong>Região Dominante:</strong> Sudeste (60%)</p>
                    `;
                    break;
                case 'financeiro':
                    dadosRelatorio = `
                        <h4>💰 Relatório Financeiro - ${new Date().toLocaleDateString()}</h4>
                        <p><strong>Receita Total:</strong> R$ 89.500,00</p>
                        <p><strong>Margem de Lucro:</strong> 32%</p>
                        <p><strong>Fluxo de Caixa:</strong> Positivo</p>
                        <p><strong>Projeção Mensal:</strong> R$ 95.000,00</p>
                    `;
                    break;
                case 'equipe':
                    dadosRelatorio = `
                        <h4>👔 Performance da Equipe - ${new Date().toLocaleDateString()}</h4>
                        <p><strong>Top Vendedor:</strong> Maria Silva (8 vendas)</p>
                        <p><strong>Meta Atingida:</strong> 92% da equipe</p>
                        <p><strong>Produtividade Média:</strong> 85%</p>
                        <p><strong>Vendas por Vendedor:</strong> 3.2 vendas/mês</p>
                    `;
                    break;
                case 'produtos':
                    dadosRelatorio = `
                        <h4>📦 Análise de Produtos - ${new Date().toLocaleDateString()}</h4>
                        <p><strong>Produto Mais Vendido:</strong> Produto A (45% vendas)</p>
                        <p><strong>Total de Produtos:</strong> 8 produtos ativos</p>
                        <p><strong>Rotatividade:</strong> 2.5x por mês</p>
                        <p><strong>Produto em Alta:</strong> Produto C (+25%)</p>
                    `;
                    break;
            }
            
            mostrarNotificacao(dadosRelatorio, 'info', 5000);
        }

        // Função para mostrar notificações
        function mostrarNotificacao(mensagem, tipo = 'info', duracao = 3000) {
            // Remover notificação anterior se existir
            const notificacaoAnterior = document.querySelector('.notification');
            if (notificacaoAnterior) {
                notificacaoAnterior.remove();
            }
            
            const notificacao = document.createElement('div');
            notificacao.className = `notification notification-${tipo}`;
            notificacao.innerHTML = `
                <div style="
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    background: rgba(255, 255, 255, 0.98);
                    backdrop-filter: blur(20px);
                    border-radius: 15px;
                    padding: 20px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
                    border: 1px solid rgba(255, 255, 255, 0.3);
                    max-width: 350px;
                    z-index: 3000;
                    animation: slideInRight 0.3s ease;
                    border-left: 4px solid ${tipo === 'success' ? '#48bb78' : tipo === 'error' ? '#f56565' : '#667eea'};
                ">
                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}" 
                           style="color: ${tipo === 'success' ? '#48bb78' : tipo === 'error' ? '#f56565' : '#667eea'}; margin-top: 2px;"></i>
                        <div style="flex: 1; font-size: 0.9em; color: #4a5568; line-height: 1.4;">
                            ${mensagem}
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" 
                                style="background: none; border: none; color: #718096; cursor: pointer; padding: 0; margin-left: 10px;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(notificacao);
            
            // Auto remover após duracao
            setTimeout(() => {
                if (notificacao.parentElement) {
                    notificacao.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => notificacao.remove(), 300);
                }
            }, duracao);
        }

        // Adicionar CSS para animações de notificação
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Animação suave para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.report-card, .page-header, .quick-stats');
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

        // Atualizar stats automaticamente (simulação)
        function atualizarStats() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const currentValue = stat.textContent;
                if (currentValue.includes('R$')) {
                    // Para valores monetários, pequena variação
                    const numValue = parseFloat(currentValue.replace('R$ ', '').replace('K', '')) * 1000;
                    const variation = (Math.random() - 0.5) * 1000; // ±500
                    const newValue = (numValue + variation) / 1000;
                    stat.textContent = `R$ ${newValue.toFixed(1)}K`;
                } else if (!isNaN(currentValue)) {
                    // Para números simples, pequena variação
                    const numValue = parseInt(currentValue);
                    const variation = Math.floor((Math.random() - 0.5) * 4); // ±2
                    stat.textContent = Math.max(0, numValue + variation);
                }
            });
        }

        // Atualizar stats a cada 30 segundos (apenas para demonstração)
        setInterval(atualizarStats, 30000);

        // Tooltip para cards desabilitados
        document.querySelectorAll('.report-card.disabled').forEach(card => {
            card.addEventListener('mouseenter', function() {
                mostrarNotificacao('Esta funcionalidade estará disponível em breve!', 'info', 2000);
            });
        });

        // Adicionar efeito de hover nos cards
        document.querySelectorAll('.report-card:not(.disabled)').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
