<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;
$usr = $_SESSION['usr'] ?? '';

require_once 'banco.php';


// Busca todas as postagens
$result_posts = $banco->query("SELECT db_post.post_id, db_post.post_body, db_post.usr_id, db_usr.usr_name FROM db_post JOIN db_usr ON db_post.usr_id = db_usr.usr_id ORDER BY db_post.post_id DESC");
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
                    <li>Olá, <?php echo htmlspecialchars($usr); ?>!</li>
                    <li><a href="meu_perfil.php">Meu Perfil</a></li>
                    <li><a href="logout.php">Logout</a></li>   
                <?php else: ?>
                    <li>Bem-vindo!</li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <aside class="sidebar">
        <ul>
            <li><a href="pesquisa_usuario.php">Usuários</a></li>
            <li><a href="#">Mais Votadas</a></li>
            <li><a href="#">Sem Resposta</a></li>
            <li><a href="#">Categorias</a></li>
        </ul>
    </aside>

    <section class="feed">
        <?php if ($logged_in): ?>
            <div class="new-post">
                <form action="new_post.php" method="post">
                    <textarea name="post_body" rows="4" cols="50" placeholder="Escreva sua postagem aqui..." required></textarea><br>
                    <button type="submit">Postar</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Exibição das postagens -->
        <?php while ($post = $result_posts->fetch_object()): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($post->usr_name); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($post->post_body)); ?></p>
                <div class="post-info">
                    <span>Autor: <?php echo htmlspecialchars($post->usr_name); ?></span>
                    <span>Data: <?php echo htmlspecialchars($post->post_id); ?></span>
                    <?php if ($logged_in && $usr === $post->usr_name): ?>
                        <form action="delete_post.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                            <button type="submit">Apagar</button>
                        </form>
                    <?php endif; ?>
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

