<?php
session_start();
require_once 'banco.php';

if (isset($_POST['post_id']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $post_id = $_POST['post_id'];
    $usr_id = $_SESSION['usr_id'];

    if ($usr_id && likePost($post_id, $usr_id)) {
        header("Location: index.php");
        exit();
    }
}

header("Location: index.php");
exit();
?>