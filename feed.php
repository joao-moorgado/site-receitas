<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;
$usr = $_SESSION['usr'] ?? '';

require_once 'banco.php';

// Inicializa a variável de resultado da pesquisa
$usuarios_encontrados = [];

// Verifica se foi submetido um formulário de pesquisa
if (isset($_GET['pesquisa'])) {
    $termo_pesquisa = $_GET['pesquisa'];

    // Consulta para buscar usuários que correspondem ao termo de pesquisa
    $stmt = $banco->prepare("SELECT usr_id, usr_name FROM db_usr WHERE usr_name LIKE ?");
    $termo_pesquisa = '%' . $termo_pesquisa . '%'; // Adiciona % para pesquisa parcial
    $stmt->bind_param("s", $termo_pesquisa);
    $stmt->execute();
    $result = $stmt->get_result();

    // Armazena os resultados da pesquisa em um array
    while ($row = $result->fetch_object()) {
        $usuarios_encontrados[] = $row;
    }

    // Verifica se algum usuário foi encontrado
    if (empty($usuarios_encontrados)) {
        $mensagem_pesquisa = "Nenhum usuário encontrado.";
    }
}

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
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="meu_perfil.php">Meu Perfil</a></li>
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
        <?php if ($logged_in): ?>
            <div class="new-post">
                <form action="new_post.php" method="post">
                    <textarea name="post_body" rows="4" cols="50" placeholder="Escreva sua postagem aqui..." required></textarea><br>
                    <button type="submit">Postar</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Formulário de pesquisa -->
        <form action="" method="GET" class="search-form">
            <input type="text" name="pesquisa" placeholder="Pesquisar usuários">
            <button type="submit">Pesquisar</button>
        </form>

        <!-- Exibição dos resultados da pesquisa -->
        <?php if (isset($termo_pesquisa)): ?>
            <h2>Resultados da Pesquisa por "<?php echo htmlspecialchars($termo_pesquisa); ?>"</h2>
            <?php if (!empty($usuarios_encontrados)): ?>
                <ul class="search-results">
                    <?php foreach ($usuarios_encontrados as $usuario): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($usuario->usr_name); ?></h3>
                            <p><a href="perfil_usuario.php?usr_id=<?php echo $usuario->usr_id; ?>">Ver perfil</a></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><?php echo htmlspecialchars($mensagem_pesquisa); ?></p>
            <?php endif; ?>
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

