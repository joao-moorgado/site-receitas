<?php
session_start();

require_once 'banco.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usr = $_POST['usr'];
    $pwd = $_POST['pwd'];

    // Buscar usuário
    $busca = buscarUsuario($usr);

    if ($busca->num_rows == 0) {
        echo "<br> Usuário não existe";
    } else {    
        $obj = $busca->fetch_object();

        if (password_verify($pwd, $obj->usr_password)) {
            $_SESSION['usr'] = $obj->usr_name; // Corrigido para usr_name
            $_SESSION['logged_in'] = true;
            header("Location: feed.php");
            exit();
        } else {
            echo "<br> Falha de Login";
        }
    }
}

if ($_SESSION['logged_in']) {
    header("Location: feed.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estouro de Pilha Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>ESTOURO<BR>DE PILHA</h1>

<?php require_once 'form-login.php'; ?>

</body>
</html>
