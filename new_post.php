<?php
// Inicia a sessão ou continua a sessão existente
session_start();

// Obtém o nome de usuário da sessão, se disponível
$usr = $_SESSION["usr"] ?? null;

// Verifica se o usuário está logado
if (!$usr) {
    echo "Você precisa estar logado para fazer uma postagem.";
    exit();
}

// Verifica se o método de requisição é POST, indicando que o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o conteúdo da postagem enviado pelo formulário
    $post_body = $_POST['post_body'];

    // Inclui o arquivo de conexão com o banco de dados
    require_once 'banco.php';

    // Busca o ID do usuário com base no nome de usuário armazenado na sessão
    $usr_id_result = $banco->query("SELECT usr_id FROM db_usr WHERE usr_name = '$usr'");
    
    // Verifica se a consulta retornou resultados
    if ($usr_id_result->num_rows > 0) {
        // Obtém o ID do usuário
        $usr_id = $usr_id_result->fetch_object()->usr_id;

        // Prepara a declaração SQL para inserir a nova postagem
        $stmt = $banco->prepare("INSERT INTO db_post (post_body, usr_id) VALUES (?, ?)");
        // Liga os parâmetros à declaração preparada
        $stmt->bind_param('si', $post_body, $usr_id);

        // Executa a declaração SQL
        if ($stmt->execute()) {
            // Redireciona para a página de feed após a postagem ser criada com sucesso
            header("Location: index.php");
            exit();
        } else {
            // Exibe uma mensagem de erro se a execução da declaração falhar
            echo "Erro ao criar a postagem: " . $stmt->error;
        }
    } else {
        // Exibe uma mensagem se o usuário não for encontrado no banco de dados
        echo "Usuário não encontrado.";
    }
}
?>
