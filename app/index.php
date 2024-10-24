<?php

$url = 'https://jsonplaceholder.typicode.com/posts/1';
$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data) {
    $uuid = bin2hex(random_bytes(16));

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">
        <title>Cadastro</title>
    </head>
    <body>
        <div class="content">
            <div class="tab_title">
                <h2>Cadastro</h2>
                <span>Crie sua conta</span>
                <a href="signin.php"> Já possui uma conta? </a>
            </div>
            <form action="signup.php" method="POST" >
                <div class="tab_form">
                    <strong>Nome</strong>
                    <input name = "name" type="text" placeholder="Digite seu Nome" required />
                </div>
                
                <div class="tab_form">
                    <strong>E-mail</strong>
                    <input name = "email" type="email" placeholder="Digite seu E-mail" required />
                </div>
                
                <div class="tab_form">
                    <strong>Código único</strong>
                    <span class="span_placeholder">' . htmlspecialchars($uuid) . '</span>
                    <input type="hidden" name="code_user" value="' . htmlspecialchars($uuid) . '" />
                </div>

                <div class="tab_form">
                    <strong>Título</strong>
                    <span class="span_placeholder">' . htmlspecialchars($data['title']) . '</span>
                    <input type="hidden" name="title_user" value="' . htmlspecialchars($data['title']) . '" />
                </div>
                
                <div class="tab_form">
                    <strong>Senha</strong>
                    <input name = "password" type="password" placeholder="Digite sua Senha" required />
                </div>   
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </body>
    </html>';
}
?>
