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
    <title>Gestão Full - Dashboard</title>
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

        /* Welcome Section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-title {
            font-size: 2.2em;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .welcome-subtitle {
            color: #718096;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin: 0 10px;
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

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #4a5568;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #4a5568;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            margin: 0 auto 20px;
        }

        .card-title {
            color: #2d3748;
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-description {
            color: #718096;
            font-size: 0.95em;
            line-height: 1.5;
            margin-bottom: 20px;
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

            .welcome-section {
                padding: 25px;
                margin-bottom: 25px;
            }

            .welcome-title {
                font-size: 1.8em;
            }

            .welcome-subtitle {
                font-size: 1em;
            }

            .btn {
                margin: 5px;
                padding: 10px 20px;
            }

            .dashboard-grid,
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-number {
                font-size: 2em;
            }

            .card {
                padding: 25px;
            }

            .card-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3em;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }

            .welcome-section {
                padding: 20px;
            }

            .welcome-title {
                font-size: 1.5em;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
                justify-content: center;
            }

            .stats-grid {
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .dashboard-grid {
                gap: 10px;
            }

            .card {
                padding: 20px;
            }
        }

        /* Animações */
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
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="equipe.php"><i class="fas fa-users"></i> Equipe</a></li>
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
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard Principal</h2>
            </div>
            <div class="user-box">
                <span><?php echo "$saudacao, $nome_usuario"; ?></span>
                <a href="?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span class="desktop-only">Sair</span></a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1 class="welcome-title">Bem-vindo ao Gestão Full</h1>
                <p class="welcome-subtitle">Gerencie sua empresa de forma inteligente e eficiente</p>
                <div>
                    <a href="clientes.php" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Novo Cliente
                    </a>
                    <a href="pedidos.php" class="btn btn-secondary">
                        <i class="fas fa-plus"></i> Criar Pedido
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">42</div>
                    <div class="stat-label">Clientes Ativos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">18</div>
                    <div class="stat-label">Pedidos Este Mês</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Produtos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Equipe</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-title">Gerenciar Equipe</h3>
                    <p class="card-description">Cadastre e gerencie gerentes e vendedores da sua empresa</p>
                    <a href="equipe.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="card-title">Clientes</h3>
                    <p class="card-description">Mantenha informações detalhadas dos seus clientes e oportunidades</p>
                    <a href="clientes.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="card-title">Pedidos</h3>
                    <p class="card-description">Crie e acompanhe pedidos dos seus clientes</p>
                    <a href="pedidos.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 class="card-title">Produtos</h3>
                    <p class="card-description">Gerencie o catálogo de produtos da sua empresa</p>
                    <a href="produtos.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="card-title">Relatórios</h3>
                    <p class="card-description">Analise o desempenho e gere insights para seu negócio</p>
                    <a href="relatorios.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3 class="card-title">Configurações</h3>
                    <p class="card-description">Configure usuários e permissões do sistema</p>
                    <a href="configuracoes.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
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

        // Adicionar classe active ao link atual
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const links = document.querySelectorAll('.sidebar ul li a');
            
            links.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                }
            });
            
            // Se estiver na página index, marcar como ativo
            if (currentPage === 'index.php' || currentPage === '') {
                document.querySelector('a[href="index.php"]').classList.add('active');
            }
        });

        // Animação suave para os cards
        const cards = document.querySelectorAll('.card, .stat-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });

        // Resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>
