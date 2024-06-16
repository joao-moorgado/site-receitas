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
    $result = $banco->query("SELECT * FROM db_post JOIN db_usr ON db_post.usr_id = db_usr.usr_id WHERE db_post.post_id = $post_id AND db_usr.usr_name = '$usr'");

    if ($result->num_rows > 0) {
        // Apaga a postagem
        $stmt = $banco->prepare("DELETE FROM db_post WHERE post_id = ?");
        $stmt->bind_param('i', $post_id);

        if ($stmt->execute()) {
            header("Location: feed.php"); // Redireciona para o feed após a exclusão
            exit();
        } else {
            echo "Erro ao apagar a postagem: " . $stmt->error;
        }
    } else {
        echo "Você não tem permissão para apagar esta postagem.";
    }
}
?>
