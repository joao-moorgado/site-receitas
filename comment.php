<?php
session_start();
require_once 'banco.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comm_body = $_POST['comm_body'];
    $post_id = $_POST['post_id'];
    $usr_id = $_SESSION['usr_id'] ?? null;

    if ($usr_id) {
        if (registerComment($comm_body, $usr_id, $post_id)) {
            header("Location: feed.php");
            exit();
        } else {
            echo "Erro ao registrar o comentário.";
        }
    } else {
        echo "Você precisa estar logado para comentar.";
    }
}
?>
