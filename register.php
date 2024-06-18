<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <header>
        <div class="container">
            <h1>Estouro de Pilha</h1>
            <nav>
                <ul>
                    <li>Bem-vindo!</li>
                    <li><a href="index.php">Início</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="form">
            <?php
                session_start();
                require_once "banco.php";

                $error_message = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtém os dados do formulário
                    $usr = $_POST['usr'];
                    $pwd = $_POST['psw'];
                    $cnfpwd = $_POST['cnfpwd'];

                    if ($pwd !== $cnfpwd) {
                        $error_message = 'As senhas não coincidem.';
                    } else {
                        // Verifica se o usuário já existe
                        if (buscarUsuario($usr)->num_rows > 0) {
                            $error_message = 'O nome de usuário já existe. Por favor, escolha outro nome de usuário.';
                        } else {
                            // Tenta registrar o usuário
                            if (registerUser($usr, $pwd)) {
                                // Definir um sinalizador de cadastro bem-sucedido na sessão
                                $_SESSION['cadastro_sucesso'] = true;

                                // Redirecionar para a página de sucesso
                                header("Location: sucesso.php");
                                exit();
                            } else {
                                $error_message = 'Erro ao registrar o usuário. Tente novamente.';
                            }
                        }
                    }
                }

                if (!empty($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }

                // Inclui o formulário de registro
                include "form_register.php";
            ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Estouro de Pilha. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>
