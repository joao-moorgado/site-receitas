<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    
    <h1>ESTOURO<BR>DE PILHA</h1>
    <?php

session_start();

require_once "form_register.php";
require_once "banco.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtém os dados do formulário
    $usr = $_POST['usr'];
    $pwd = $_POST['psw'];
    $cnfpwd = $_POST['cnfpwd'];

    if ($pwd !== $cnfpwd) {
        echo 'As senhas não coincidem.';
    } else {
        // Chama a função para registrar o usuário
        registerUser($usr, $pwd);

        // Definir um sinalizador de cadastro bem-sucedido na sessão
        $_SESSION['cadastro_sucesso'] = true;

        // Redirecionar para a página de sucesso
        header("Location: sucesso.php");
        exit();
    }

}

    ?>

</body>
</html>