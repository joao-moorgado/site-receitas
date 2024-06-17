<?php
session_start();
$usr = $_SESSION["usr"] ?? null;

if (!$usr) {
    echo "Você precisa estar logado para apagar uma postagem.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];

    require_once 'banco.php';

    // Verifica se a postagem pertence ao usuário logado
    $stmt_check_post = $banco->prepare("SELECT * FROM db_post JOIN db_usr ON db_post.usr_id = db_usr.usr_id WHERE db_post.post_id = ? AND db_usr.usr_name = ?");
    $stmt_check_post->bind_param('is', $post_id, $usr);
    $stmt_check_post->execute();
    $result_check_post = $stmt_check_post->get_result();

    if ($result_check_post->num_rows > 0) {
        // Excluir comentários relacionados à postagem
        $stmt_delete_comments = $banco->prepare("DELETE FROM db_comm WHERE post_id = ?");
        $stmt_delete_comments->bind_param('i', $post_id);
        if ($stmt_delete_comments->execute()) {
            // Apaga a postagem
            $stmt_delete_post = $banco->prepare("DELETE FROM db_post WHERE post_id = ?");
            $stmt_delete_post->bind_param('i', $post_id);
            
            if ($stmt_delete_post->execute()) {
                header("Location: feed.php"); // Redireciona para o feed após a exclusão
                exit();
            } else {
                echo "Erro ao apagar a postagem: " . $stmt_delete_post->error;
            }
        } else {
            echo "Erro ao apagar os comentários: " . $stmt_delete_comments->error;
        }
    } else {
        echo "Você não tem permissão para apagar esta postagem.";
    }
}
?>
