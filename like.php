<?php
session_start();
require_once 'banco.php';

if (isset($_POST['post_id'])) {
  $post_id = $_POST['post_id'];
  $usr_id = $_SESSION['usr_id'];
  if (likePost($post_id, $usr_id)) {
    header("Location: feed.php");
    exit();
  } else {
    echo "Erro ao registrar a curtida.";
  }
}
?>