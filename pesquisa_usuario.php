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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <main class="pesquisa-usuario">
        <!-- Formulário de pesquisa -->
     <form action="" method="GET" class="search-form">
        <input type="text" name="pesquisa" placeholder="Pesquisar usuários">
        <button type="submit">Pesquisar</button> <br>
    </form>

        <!-- Exibição dos resultados da pesquisa -->
    <?php if (isset($termo_pesquisa)): ?>
        <h2>Resultados da Pesquisa por "<?php echo htmlspecialchars($_GET['pesquisa']); ?>"</h2>
        <?php if (!empty($usuarios_encontrados)): ?>
            <ul class="search-results">
                <?php foreach ($usuarios_encontrados as $usuario): ?> <br>
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
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Estouro de Pilha. Todos os direitos reservados.</p>
        </div>
    </footer>
     
</body>
</html>