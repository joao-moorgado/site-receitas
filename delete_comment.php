<?php
session_start();
$usr_id = $_SESSION['usr_id'] ?? null;

if (!$usr_id) {
    echo "Você precisa estar logado para apagar um comentário.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comm_id = $_POST['comm_id'];

    require_once 'banco.php';

    // Verifica se o comentário pertence ao usuário logado
    $stmt_check_comment = $banco->prepare("SELECT * FROM db_comm WHERE comm_id = ? AND usr_id = ?");
    $stmt_check_comment->bind_param('ii', $comm_id, $usr_id);
    $stmt_check_comment->execute();
    $result_check_comment = $stmt_check_comment->get_result();

    if ($result_check_comment->num_rows > 0) {
        // Apaga o comentário
        $stmt_delete_comment = $banco->prepare("DELETE FROM db_comm WHERE comm_id = ?");
        $stmt_delete_comment->bind_param('i', $comm_id);
        
        if ($stmt_delete_comment->execute()) {
            header("Location: feed.php"); // Redireciona para o feed após a exclusão
            exit();
        } else {
            echo "Erro ao apagar o comentário: " . $stmt_delete_comment->error;
        }
    } else {
        echo "Você não tem permissão para apagar este comentário.";
    }
}
?>
