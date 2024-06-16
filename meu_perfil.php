<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;
$usr = $_SESSION['usr'] ?? '';

require_once 'banco.php';

// Consulta para obter todas as postagens do usuário logado
$stmt_posts = $banco->prepare("SELECT post_id, post_body FROM db_post WHERE usr_id = ?");
$stmt_posts->bind_param("s", $usr);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <div class="container">
        <h1>Estouro de Pilha</h1>
        <nav>
            <ul>
                <?php if ($logged_in): ?>
                    <li>Olá, <?php echo htmlspecialchars($usr); ?>!</li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="perfil_usuario.php?usr_id=<?php echo urlencode($usr); ?>">Meu Perfil</a></li>
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
    <h2>Minhas Postagens</h2>

    <section class="feed">
        <?php while ($post = $result_posts->fetch_object()): ?>
            <div class="post">
                <p><?php echo nl2br(htmlspecialchars($post->post_body)); ?></p>
                <div class="post-info">
                    <span>Data: <?php echo htmlspecialchars($post->post_id); ?></span>
                    <form action="delete_post.php" method="post" style="display:inline;">
                        <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                        <button type="submit">Apagar</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Estouro de Pilha. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
