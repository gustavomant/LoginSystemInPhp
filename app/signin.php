<?php
session_start();

try {
    $dsn = 'mysql:host=mysql;dbname=' . getenv('MYSQL_DATABASE');
    $username = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro de Conexão: " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo "E-mail e Senha são necessários.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email_user = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_user'])) {
        $_SESSION['user_id'] = $user['in_user'];
        $_SESSION['user_name'] = $user['name_user'];
        echo "Login bem sucedido . Bem-vindo, " . htmlspecialchars($user['name_user']) . "!";
        echo '<a href="dashboard.php"> Dashboard </a>';
    } else {
        http_response_code(401);
        echo "E-mail ou Senha inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>SignIn</title>
</head>
<body>
    <div class="content">
        <div class="tab_title">
            <h2>Faça seu login</h2>
            <a href="index.php"> Não tem uma conta? </a>
            <span>Use Suas Credenciais</span>
        </div>
        <form method="POST" >
            <div class="tab_form">
                <strong>E-mail</strong>
                <input name = "email" type="email" placeholder="Digite seu E-mail" required />
            </div>

            <div class="tab_form">
                <strong>Senha</strong>
                <input name = "password" type="password" placeholder="Digite sua Senha" required />
            </div>   
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>