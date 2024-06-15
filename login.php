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
        $usr = $_POST['user'];
        $pwd = $_POST['password'];

        // Teste para ver se o input funcionou
        echo $usr . ' - ' . $pwd;

        // Buscar usuário - ainda em desenvolvimento
        $busca = buscarUsuario($usr);
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Código que estou usando de base para fazer a página de login

        session_start();
        
        $usu = $_SESSION["usuario"] ?? null;

        if(!is_null($usu)){
            // estou logado
            header("Location: Aula14.php");
        }else{

            require_once "banco.php";

            $usu = $_POST['usuario'] ?? null;
            $sen = $_POST['senha'] ?? null;

            if(is_null($usu) || is_null($sen)){
                require_once "form-login.php";
            }else{
                require_once "form-login.php"; // para testes

                echo "~ [Usuario: $usu - Senha: $sen] ~ <br>";

                $busca = buscarUsuario($usu);

                if($busca->num_rows == 0){
                    echo "<br> Usuário não existe";
                }else{
                    echo "<br> boa";
                    
                    $obj = $busca->fetch_object();
                    echo "<br>" . $obj->usuario;
                    echo "<br>" . $obj->nome;
                    echo "<br>" . $obj->senha;

                    // if($sen === $obj->senha){
                    if(password_verify($sen, $obj->senha)){
                        echo "<br> sucesso!";
                    }else{
                        echo "<br> sem sucesso :/";
                    }

                }

                
            }
            
      }
    ?>

</body>
</html>
