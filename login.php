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

        // Conexão com o banco de dados
        require_once 'banco.php';
        // Import do formulário
        require_once 'form-login.php';

        // Input do usuário e senha
        $usr = $_POST['usr'];
        $pwd = $_POST['pwd'];

        // Teste para ver se o input funcionou
        echo $usr . ' - ' . $pwd;

        echo '<br>';

        // Buscar usuário
        $busca = buscarUsuario($usr);

        // Login - em desenvolvimento
        if($busca->num_rows == 0){
            echo "<br> Usuário não existe";
        }else{
            echo "<br> Usuário existe";
        
            $obj = $busca->fetch_object();
                    echo "<br>" . $obj->usr_name;
                    echo "<br>" . $obj->usr_password;
                    echo "<br>" . $pwd;

                    if(password_verify($pwd, $obj->usr_password)){
                        echo "<br> Sucesso";
                    }else{
                        echo "<br> Sem sucesso";
                    }
                }
    ?>

</body>
</html>
