<?php
session_start();
$logged_in = $_SESSION['logged_in'] ?? false;
$usr = $_SESSION['usr'] ?? '';

require_once 'banco.php';

// Verifica se foi passado o usr_id via GET
if (!isset($_GET['usr_id'])) {
    header("Location: index.php");
    exit();
}

$usr_id = $_GET['usr_id'];

// Consulta para obter informações do usuário
$stmt = $banco->prepare("SELECT usr_name FROM db_usr WHERE usr_id = ?");
$stmt->bind_param("i", $usr_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Usuário não encontrado.";
    exit();
}

$usuario = $result->fetch_object();

// Consulta para obter todas as postagens do usuário
$stmt_posts = $banco->prepare("SELECT post_id, post_body FROM db_post WHERE usr_id = ?");
$stmt_posts->bind_param("i", $usr_id);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($usuario->usr_name); ?></title>
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
                    <li><a href="index.php">Início</a></li>
                    <li><a href="meu_perfil.php">Meu Perfil</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li>Bem-vindo!</li>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <section class="feed">
    <h2>Postagens de <?php echo htmlspecialchars($usuario->usr_name);?>:</h2>
        <?php while ($post = $result_posts->fetch_object()):?>
            <div class="post">
                <p><?php echo nl2br(htmlspecialchars($post->post_body));?></p>
                <div class="post-info">
                    <span>Data: <?php echo htmlspecialchars($post->post_id);?></span>
                    <span>Curtidas: <?php echo countLikes($post->post_id);?></span>
                </div>
            </div>
        <?php endwhile;?>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Estouro de Pilha. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
