<?php
    session_start();
    unset($_SESSION['usr']);
    unset($_SESSION['logged_in']);
    header("Location: index.php");
    exit();
?>
