<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;

$usr = $_SESSION['usr'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estouro de Pilha</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
    <div class="container">
        <h1>Estouro de Pilha</h1>
        <nav>
            <ul>
                <?php if ($logged_in): ?>
                    <li>Olá!</li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li>Bem-vindo!</li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Cadastro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <aside class="sidebar">
        <ul>
            <li><a href="#">Últimas Perguntas</a></li>
            <li><a href="#">Mais Votadas</a></li>
            <li><a href="#">Sem Resposta</a></li>
            <li><a href="#">Categorias</a></li>
        </ul>
    </aside>
    
    <section class="feed">
        <div class="post">
            <h2>Titulo</h2>
            <p>Conteudo</p>
            <div class="post-info">
                <span>Autor: Usuário123</span>
                <span>Data: 15/06/2024</span>
                <span>Respostas: 5</span>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Estouro de Pilha. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>