<?php
// Incluir arquivo de conexão com o banco de dados
include 'conexao.php'; // Substitua pelo caminho do seu script de conexão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Proteção contra SQL injection (opcional)
    $username = mysqli_real_escape_string($conexao, $username);
    $password = mysqli_real_escape_string($conexao, $password);

    // Criptografa a senha (recomendado usar password_hash() para segurança)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insere os dados na tabela db_usr
    $sql = "INSERT INTO db_usr (usr_name, usr_password) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($conexao, $sql)) {
        echo "Usuário registrado com sucesso.";
    } else {
        echo "Erro ao registrar o usuário: " . mysqli_error($conexao);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
}
?>
