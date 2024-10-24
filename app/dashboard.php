<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

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

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE in_user = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="content">
        <div class="tab_title">
            <h2>Dashboard</h2>
            <p>Bem Vindo, <?php echo htmlspecialchars($user['name_user']); ?>!</p>
        </div>
        
        <div class="tab_form">
            <strong>Seu Email: </strong>
            <p><?php echo htmlspecialchars($user['email_user']); ?></p>
        </div>

        <div class="tab_form">
            <strong>Seu Código: </strong>
            <p><?php echo htmlspecialchars($user['code_user']); ?></p>
        </div>

        <a href="logout.php">Sair</a>
    </div>
</body>
</html>
