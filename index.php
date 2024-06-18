<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;
$usr = $_SESSION['usr'] ?? '';

require_once 'banco.php'; // Inclui o arquivo onde countLikes() já está definido

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <?php if ($logged_in): ?>
                <li><a href="meu_perfil.php">Meu Perfil</a></li>
            <?php endif; ?>
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

        <?php while ($post = $result_posts->fetch_object()): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($post->usr_name); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($post->post_body)); ?></p>
                <div class="post-info">
                    <span>Autor: <?php echo htmlspecialchars($post->usr_name); ?></span>
                    <?php if ($logged_in && $usr === $post->usr_name): ?>
                        <form action="delete_post.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                            <button type="submit">Apagar</button>
                        </form>
                    <?php endif; ?>
                    
                    <!-- Exibir botão curtir se o usuário estiver logado -->
                    <?php if ($logged_in): ?>
                        <form action="like.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                            <button type="submit">
                                <?php
                                    // Verifica se o usuário já curtiu o post
                                    $stmt_check_like = $banco->prepare("SELECT * FROM db_likes WHERE post_id = ? AND usr_id = ?");
                                    $stmt_check_like->bind_param("ii", $post->post_id, $_SESSION['usr_id']);
                                    $stmt_check_like->execute();
                                    $result_check_like = $stmt_check_like->get_result();

                                    echo ($result_check_like->num_rows > 0) ? 'Descurtir' : 'Curtir';
                                ?>
                                (<?php echo countLikes($post->post_id); ?>)
                            </button>
                        </form>
                    <?php else: ?>
                        <!-- Exibir apenas a contagem de curtidas se o usuário não estiver logado -->
                        <span>Curtidas: (<?php echo countLikes($post->post_id); ?>)</span>
                    <?php endif; ?>
                </div>

                <!-- Seção de Comentários -->
                <div class="comments">
                    <h3>Comentários</h3>
                    <?php
                    $sql_comments = "SELECT db_comm.comm_id, db_comm.comm_body, db_comm.usr_id, db_usr.usr_name FROM db_comm JOIN db_usr ON db_comm.usr_id = db_usr.usr_id WHERE db_comm.post_id = ? ORDER BY db_comm.comm_id ASC";
                    $stmt_comments = $banco->prepare($sql_comments);
                    $stmt_comments->bind_param("i", $post->post_id);
                    $stmt_comments->execute();
                    $result_comments = $stmt_comments->get_result();
                    while ($comment = $result_comments->fetch_object()):
                    ?>
                        <div class="comment">
                            <p><b><?php echo htmlspecialchars($comment->usr_name); ?>: </b><?php echo nl2br(htmlspecialchars($comment->comm_body)); ?></p>
                            <?php if ($logged_in && ($comment->usr_id == $_SESSION['usr_id'])): ?>
                                <form action="delete_comment.php" method="post" style="display: inline;">
                                    <input type="hidden" name="comm_id" value="<?php echo $comment->comm_id; ?>">
                                    <button type="submit">Apagar Comentário</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>

                    <!-- Formulário para novo comentário -->
                    <?php if ($logged_in): ?>
                        <form action="comment.php" method="post">
                            <textarea name="comm_body" rows="2" cols="50" placeholder="Escreva um comentário..." required></textarea><br>
                            <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                            <button type="submit">Comentar</button>
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
