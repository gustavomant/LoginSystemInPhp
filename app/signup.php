<?php
$dsn = 'mysql:host=mysql;dbname=' . getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;
        $code_user = isset($_POST["code_user"]) ? trim($_POST["code_user"]) : null;
        $title_user = isset($_POST["title_user"]) ? trim($_POST["title_user"]) : null;
    
        if (empty($name) || empty($email) || empty($password)) {
            http_response_code(400);
            echo "Bad Request: Nome, E-mail ou Senha estão faltando.";
            exit;
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name_user, email_user, password_user, code_user, title_user) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $code_user, $title_user]);
        echo "Usuário registrado com código " . htmlspecialchars($code_user) . " e título: " . htmlspecialchars($title_user);
    } else {
        http_response_code(405);
        echo "Metódo não permitido";
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000 && strpos($e->getMessage(), '1062 Duplicate') !== false) {
        echo "Erro: Já existe um registro com os mesmos dados (entrada duplicada).";
    } else {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>
