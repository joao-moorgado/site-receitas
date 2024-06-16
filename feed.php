<?php
session_start();
$usr = $_SESSION["usr"] ?? null;
$logged_in = $_SESSION["logged_in"] ?? false;
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
<?php
    if ($logged_in) {
        header("Location: feed.php");
        exit();
    } else {
        // Conexão com o banco de dados
        require_once 'banco.php';
    
        // Import do formulário
        require_once 'form-login.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Input do usuário e senha
            $usr = $_POST['usr'];
            $pwd = $_POST['pwd'];

            // Buscar usuário
            $busca = buscarUsuario($usr);

            // Login - em desenvolvimento
            if ($busca->num_rows == 0) {
                echo "<br> Usuário não existe";
            } else {    
                $obj = $busca->fetch_object();
    
                if (password_verify($pwd, $obj->usr_password)) {
                    $_SESSION['usr'] = $obj->usr;
                    $_SESSION['logged_in'] = true;
                    header("Location: feed.php");
                    exit();
                } else {
                    echo "<br> Falha de Login";
                }
            }
        }
    }
?>
</body>
</html>
