<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; // Endereço do servidor MySQL (geralmente 'localhost' para ambiente local)
$username = "root"; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = "db_estouro_de_pilha"; // Nome do banco de dados

// Estabelece a conexão com o banco de dados
$conexao = mysqli_connect($servername, $username, $password, $dbname);

// Verifica a conexão
if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Configura o charset para utf8mb4 (opcional)
mysqli_set_charset($conexao, "utf8mb4");

// Retorna a conexão para ser utilizada em outros scripts
return $conexao;
?>
