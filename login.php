<?php
session_start();
require_once 'conexao.php';

// Verificar se o usuário já está logado
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

// Processar login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if ($email && $senha) {
        $stmt = $conn->prepare("SELECT id, email, senha, permissao FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && (password_verify($senha, $user['senha']) || $senha === $user['senha'])) {
            // Atualizar senha para hash se ainda estiver em texto plano
            if ($senha === $user['senha']) {
                $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
                $update_stmt->bind_param("si", $hashed_senha, $user['id']);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // Buscar nome do usuário após atualização
            $nome_stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
            $nome_stmt->bind_param("i", $user['id']);
            $nome_stmt->execute();
            $nome_result = $nome_stmt->get_result();
            $nome_user = $nome_result->fetch_assoc();
            $nome_stmt->close();

            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $nome_user['nome'];
            $_SESSION['permissao'] = $user['permissao'];

            header('Location: index.php');
            exit;
        } else {
            $mensagem = "Email ou senha inválidos.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Full - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #555;
        }

        .mensagem {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .mensagem.erro {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($mensagem)): ?>
            <div class="mensagem erro"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>