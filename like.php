<?php
  session_start();
  require_once 'banco.php';
  $logged_in = $_SESSION['logged_in'] ?? false;

  if (isset($_POST['post_id']) && ($logged_in)) {
    $post_id = $_POST['post_id'];
    $usr_id = $_SESSION['usr_id'];
    if ($usr_id && likePost($post_id, $usr_id)) {
      header("Location: index.php");
      exit();
    } else {
      header("Location: index.php");
      exit();
    }
  } else{
      header("Location: index.php");
      exit();
  }
?>